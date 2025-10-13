<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Subscriptions\Models\SubscriptionPlan;
use App\Modules\Subscriptions\Models\Subscription;

class SpmSubscriptionController extends Controller
{
    /**
     * Show SPM subscription plans page
     */
    public function index()
    {
        $user = auth()->user();

        // Get SPM plans only
        $spmPlans = SubscriptionPlan::where('plan_type', 'spm')
            ->where('is_active', true)
            ->orderBy('price', 'asc')
            ->get();

        // Get user's active SPM subscription
        $activeSubscription = $user->activeSpmSubscription();

        // Get SPM access status
        $hasSpmAccess = $user->hasSpmAccess();
        $spmLimits = $user->getSpmLimits();

        return view('spm.subscriptions.index', compact(
            'spmPlans',
            'activeSubscription',
            'hasSpmAccess',
            'spmLimits'
        ));
    }

    /**
     * Show checkout page for specific plan
     */
    public function checkout($planId)
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::where('plan_type', 'spm')
            ->where('is_active', true)
            ->findOrFail($planId);

        // Check if user already has an active SPM subscription
        $activeSubscription = $user->activeSpmSubscription();

        if ($activeSubscription && $activeSubscription->plan_id == $planId) {
            return redirect()->route('spm.subscriptions.index')
                ->with('info', 'You already have an active subscription to this plan.');
        }

        return view('spm.subscriptions.checkout', compact('plan', 'activeSubscription'));
    }

    /**
     * Process subscription purchase
     */
    public function purchase(Request $request, $planId)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,stripe,paypal',
            'terms' => 'accepted',
        ]);

        $user = auth()->user();
        $plan = SubscriptionPlan::where('plan_type', 'spm')
            ->where('is_active', true)
            ->findOrFail($planId);

        // Check if free plan
        if ($plan->price == 0) {
            return $this->activateSubscription($user, $plan);
        }

        // Process payment based on method
        switch ($request->payment_method) {
            case 'wallet':
                return $this->processWalletPayment($user, $plan);
            case 'stripe':
                return $this->processStripePayment($user, $plan);
            case 'paypal':
                return $this->processPaypalPayment($user, $plan);
            default:
                return back()->with('error', 'Invalid payment method');
        }
    }

    /**
     * Process wallet payment
     */
    private function processWalletPayment($user, $plan)
    {
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $plan->price) {
            return back()->with('error', 'Insufficient wallet balance. Please add funds to your wallet.');
        }

        // Deduct from wallet
        $wallet->decrement('balance', $plan->price);

        // Create wallet transaction
        $user->walletTransactions()->create([
            'type' => 'debit',
            'amount' => $plan->price,
            'description' => 'SPM Subscription: ' . $plan->name,
            'status' => 'completed',
        ]);

        return $this->activateSubscription($user, $plan, 'wallet');
    }

    /**
     * Process Stripe payment (placeholder)
     */
    private function processStripePayment($user, $plan)
    {
        // TODO: Implement Stripe payment processing
        return back()->with('error', 'Stripe payment integration coming soon.');
    }

    /**
     * Process PayPal payment (placeholder)
     */
    private function processPaypalPayment($user, $plan)
    {
        // TODO: Implement PayPal payment processing
        return back()->with('error', 'PayPal payment integration coming soon.');
    }

    /**
     * Activate subscription
     */
    private function activateSubscription($user, $plan, $paymentMethod = 'free')
    {
        // Cancel any existing active SPM subscription
        $existingSubscription = $user->activeSpmSubscription();
        if ($existingSubscription) {
            $existingSubscription->update(['status' => 'cancelled']);
        }

        // Calculate subscription period
        $startsAt = now();
        $endsAt = match ($plan->billing_period) {
            'monthly' => $startsAt->copy()->addMonth(),
            'yearly' => $startsAt->copy()->addYear(),
            'lifetime' => null,
            default => $startsAt->copy()->addMonth(),
        };

        // Create new subscription
        $subscription = $user->subscriptions()->create([
            'subscription_plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'payment_status' => 'paid',
            'transaction_id' => uniqid('spm_'),
        ]);

        // Grant SPM access to user
        $planType = match ($plan->name) {
            'SPM Free' => 'free',
            'SPM Basic' => 'basic',
            'SPM Pro' => 'pro',
            'SPM Enterprise' => 'enterprise',
            default => 'free',
        };

        $user->grantSpmAccess($planType, $endsAt);

        return redirect()->route('spm.subscriptions.index')
            ->with('success', 'SPM subscription activated successfully! You can now access the Smart Project Manager.');
    }

    /**
     * Cancel subscription
     */
    public function cancel(Request $request)
    {
        $user = auth()->user();
        $subscription = $user->activeSpmSubscription();

        if (!$subscription) {
            return back()->with('error', 'No active subscription found.');
        }

        // Update subscription status
        $subscription->update(['status' => 'cancelled']);

        // Revoke SPM access
        $user->revokeSpmAccess();

        return redirect()->route('spm.subscriptions.index')
            ->with('success', 'SPM subscription cancelled successfully.');
    }

    /**
     * Upgrade/Downgrade subscription
     */
    public function changePlan(Request $request, $planId)
    {
        $user = auth()->user();
        $newPlan = SubscriptionPlan::where('plan_type', 'spm')
            ->where('is_active', true)
            ->findOrFail($planId);

        $currentSubscription = $user->activeSpmSubscription();

        if (!$currentSubscription) {
            return redirect()->route('spm.subscriptions.checkout', $planId);
        }

        $currentPlan = $currentSubscription->plan;

        // Calculate prorated amount
        if ($newPlan->price > $currentPlan->price) {
            // Upgrade - charge difference
            $daysRemaining = now()->diffInDays($currentSubscription->ends_at);
            $totalDays = $currentSubscription->starts_at->diffInDays($currentSubscription->ends_at);
            $proratedAmount = ($newPlan->price - $currentPlan->price) * ($daysRemaining / $totalDays);

            // Process payment for prorated amount
            // For now, we'll just activate the new plan
        }

        // Update subscription
        $currentSubscription->update([
            'subscription_plan_id' => $newPlan->id,
        ]);

        $planType = match ($newPlan->name) {
            'SPM Free' => 'free',
            'SPM Basic' => 'basic',
            'SPM Pro' => 'pro',
            'SPM Enterprise' => 'enterprise',
            default => 'free',
        };

        $user->update(['spm_plan' => $planType]);

        return redirect()->route('spm.subscriptions.index')
            ->with('success', 'Plan changed successfully!');
    }
}
