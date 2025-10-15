<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Modules\Jobs\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('client_id', auth()->id())
            ->with('bids')
            ->latest()
            ->paginate(10);

        return view('client.jobs.index', compact('jobs'));
    }

    public function create()
    {
        // Get user's purchased products for support job option
        $purchasedProducts = \App\Modules\Orders\Models\Order::where('buyer_id', auth()->id())
            ->where('status', 'completed')
            ->with('orderable')
            ->whereHasMorph('orderable', [\App\Modules\Products\Models\Product::class])
            ->latest()
            ->get()
            ->pluck('orderable')
            ->unique('id')
            ->filter();

         // Get user's active subscriptions
         $activeSubscriptions = \App\Modules\Subscriptions\Models\Subscription::where('user_id', auth()->id())
             ->where('status', 'active')
             ->where('ends_at', '>', now())
             ->with('plan')
             ->latest()
             ->get();

        return view('client.jobs.create', compact('purchasedProducts', 'activeSubscriptions'));
    }

     public function store(Request $request)
     {
         $user = auth()->user();

         // Check project limit
         if (!$user->canPostProject()) {
             return back()->with('error', 'You have reached your project posting limit. Upgrade your plan to post more projects.');
         }

         // Check verification if required
         if ($user->requiresVerification() && !$user->kyc) {
             return back()->with('error', 'Verification is required for your plan. Please complete KYC verification.');
         }

         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'category' => 'required|string|max:100',
             'budget_min' => 'required|numeric|min:1',
             'budget_max' => 'required|numeric|min:1|gte:budget_min',
             'duration' => 'nullable|string|max:100',
             'skills_required' => 'nullable|string',
             'expires_at' => 'nullable|date|after:today',
             'job_type' => 'nullable|in:regular,support',
             'product_id' => 'nullable|exists:products,id',
             'order_id' => 'nullable|exists:orders,id',
         ]);

        // Process skills
        if (!empty($validated['skills_required'])) {
            $skills = array_map('trim', explode(',', $validated['skills_required']));
            $validated['skills_required'] = $skills;
        } else {
            $validated['skills_required'] = [];
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);

        // Set client ID
        $validated['client_id'] = auth()->id();

        // Set status based on submit button
        $validated['status'] = $request->input('status', 'open');

        // Set default currency
        $validated['currency'] = 'USD';

        // Handle job type
        $validated['job_type'] = $request->input('job_type', 'regular');

         // Check if user has active subscription for priority
         $activeSubscription = \App\Modules\Subscriptions\Models\Subscription::where('user_id', auth()->id())
             ->where('status', 'active')
             ->where('ends_at', '>', now())
             ->first();

         if ($activeSubscription) {
             $validated['priority'] = 1; // Higher priority for subscription users
         }

        // For support jobs, set product_id and add to vendor's queue
        if ($validated['job_type'] === 'support' && $request->has('product_id')) {
            $validated['product_id'] = $request->product_id;
            $validated['priority'] = 2; // Highest priority for support requests
        }

        $job = Job::create($validated);

        return redirect()->route('client.jobs.show', $job->id)
            ->with('success', 'Job posted successfully!');
    }

    public function show(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        $job->load('bids.freelancer');

        return view('client.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        return view('client.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'budget_min' => 'required|numeric|min:1',
            'budget_max' => 'required|numeric|min:1|gte:budget_min',
            'duration' => 'nullable|string|max:100',
            'skills_required' => 'nullable|string',
            'expires_at' => 'nullable|date|after:today',
            'status' => 'required|in:draft,open,in_progress,completed,closed',
        ]);

        // Process skills
        if (!empty($validated['skills_required'])) {
            $skills = array_map('trim', explode(',', $validated['skills_required']));
            $validated['skills_required'] = $skills;
        } else {
            $validated['skills_required'] = [];
        }

        // Update slug if title changed
        if ($job->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        }

        $job->update($validated);

        return redirect()->route('client.jobs.show', $job->id)
            ->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        // Don't allow deletion if there are accepted bids
        if ($job->bids()->where('status', 'accepted')->exists()) {
            return redirect()->route('client.jobs.index')
                ->with('error', 'Cannot delete job with accepted bids. Please complete or close the job first.');
        }

        $job->delete();

        return redirect()->route('client.jobs.index')
            ->with('success', 'Job deleted successfully!');
    }

     public function favorites()
     {
         $favoriteServices = auth()->user()->favoriteServices()->with(['user', 'category'])->paginate(12);

         return view('client.favorites', compact('favoriteServices'));
     }

    public function messages(Job $job)
    {
        // Ensure user owns this job
        if ($job->client_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this job');
        }

        $messages = $job->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        $job->messages()
            ->where('user_id', '!=', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('client.jobs.messages', compact('job', 'messages'));
    }

    public function sendMessage(Request $request, Job $job)
    {
        // Ensure user is part of this job (client or accepted freelancer)
        if ($job->client_id !== auth()->id() && !$job->bids()->where('freelancer_id', auth()->id())->where('status', 'accepted')->exists()) {
            abort(403, 'Unauthorized access to this job');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        \App\Modules\Jobs\Models\JobMessage::create([
            'job_id' => $job->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

         return redirect()->route('client.jobs.messages', $job->id)
             ->with('success', 'Message sent successfully!');
     }

     public function profile()
     {
         $user = auth()->user();
         $activeSubscription = $user->activeClientSubscription();
         $plans = \App\Modules\Subscriptions\Models\SubscriptionPlan::where('plan_type', 'client')
             ->where('is_active', true)
             ->get();

         return view('client.profile', compact('user', 'activeSubscription', 'plans'));
     }

     public function plans()
     {
         $plans = \App\Modules\Subscriptions\Models\SubscriptionPlan::where('plan_type', 'client')
             ->where('is_active', true)
             ->get();

         return view('client.plans', compact('plans'));
     }

     public function showPlanCheckout($planId)
     {
         $plan = \App\Modules\Subscriptions\Models\SubscriptionPlan::findOrFail($planId);
         $cost = $plan->price;
         $gateways = \App\Modules\Payments\Models\PaymentGateway::where('is_active', true)->get();

         return view('client.plan-checkout', compact('plan', 'cost', 'gateways'));
     }

     public function processPlanCheckout(Request $request, $planId)
     {
         $request->validate([
             'gateway_id' => 'required|exists:payment_gateways,id',
             'terms' => 'accepted',
         ]);

         $user = auth()->user();
         $plan = \App\Modules\Subscriptions\Models\SubscriptionPlan::findOrFail($planId);
         $cost = $plan->price;

         // Check if user already has an active subscription for this plan type
         $existingSubscription = $user->activeClientSubscription();
         if ($existingSubscription) {
             return back()->with('error', 'You already have an active client subscription.');
         }

         $gateway = \App\Modules\Payments\Models\PaymentGateway::find($request->gateway_id);

         if ($gateway && $gateway->is_active) {
             // Simulate payment processing
             $paymentSuccess = true; // In real app, use gateway API

             if ($paymentSuccess) {
                 // Create subscription
                 \App\Modules\Subscriptions\Models\Subscription::create([
                     'user_id' => $user->id,
                     'subscription_plan_id' => $plan->id,
                     'status' => 'active',
                     'payment_status' => 'paid',
                     'starts_at' => now(),
                     'ends_at' => $plan->billing_period === 'monthly' ? now()->addMonth() : now()->addYear(),
                 ]);

                 return redirect()->route('client.profile')->with('success', "Successfully subscribed to {$plan->name} plan.");
             }
         }

         return back()->with('error', 'Payment failed. Please try again.');
     }
 }
