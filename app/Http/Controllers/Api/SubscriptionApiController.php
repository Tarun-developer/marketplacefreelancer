<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Subscriptions\Models\SubscriptionPlan;
use App\Modules\Subscriptions\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionApiController extends Controller
{
    public function plans()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return response()->json($plans);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = $request->user();

        // Cancel existing subscription
        $user->subscriptions()->update(['status' => 'cancelled']);

        // Create new subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'payment_status' => 'paid', // Assume paid for now
        ]);

        return response()->json($subscription->load('plan'), 201);
    }

    public function mySubscription(Request $request)
    {
        $subscription = $request->user()->subscriptions()->where('status', 'active')->first();
        return response()->json($subscription?->load('plan'));
    }

    public function cancel(Request $request)
    {
        $subscription = $request->user()->subscriptions()->where('status', 'active')->first();
        if ($subscription) {
            $subscription->update(['status' => 'cancelled']);
        }

        return response()->json(['message' => 'Subscription cancelled']);
    }
}