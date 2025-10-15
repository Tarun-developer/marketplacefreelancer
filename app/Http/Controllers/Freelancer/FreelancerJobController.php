<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Bid;
use Illuminate\Http\Request;

class FreelancerJobController extends Controller
{
    public function index()
    {
        $jobs = Job::where('status', 'open')->paginate(10);

        return view('freelancer.jobs.index', compact('jobs'));
    }

    public function show(Job $job)
    {
        return view('freelancer.jobs.show', compact('job'));
    }

     public function storeBid(Request $request, Job $job)
     {
         $request->validate([
             'proposal' => 'required|string',
             'price' => 'required|numeric|min:0',
             'duration' => 'required|integer|min:1',
         ]);

         $user = auth()->user();

         // Check bid limit
         if (!$user->canPlaceBid()) {
             return back()->with('error', 'You have reached your monthly bid limit. Upgrade your plan or purchase extra bids.');
         }

         // Check if user already bid on this job
         $existingBid = Bid::where('job_id', $job->id)
                           ->where('freelancer_id', $user->id)
                           ->first();

         if ($existingBid) {
             return back()->with('error', 'You have already submitted a bid for this job.');
         }

         Bid::create([
             'job_id' => $job->id,
             'freelancer_id' => $user->id,
             'proposal' => $request->proposal,
             'price' => $request->price,
             'currency' => 'USD', // or from request
             'duration' => $request->duration,
             'status' => 'pending',
         ]);

         // Increment bid count
         $user->incrementBidCount();

         return back()->with('success', 'Your bid has been submitted successfully.');
     }

     public function buyBids()
     {
         return view('freelancer.buy-bids');
     }

     public function purchaseBids(Request $request)
     {
         $request->validate([
             'bid_pack' => 'required|integer|in:5,10,20',
         ]);

         $user = auth()->user();
         $packSize = $request->bid_pack;
         $cost = $packSize * 1; // $1 per bid, adjust as needed

         if ($user->wallet && $user->wallet->balance >= $cost) {
             $user->wallet->decrement('balance', $cost);
             $user->addExtraBids($packSize);

             return redirect()->route('freelancer.proposals.index')->with('success', "Purchased {$packSize} extra bids.");
         }

         return back()->with('error', 'Insufficient wallet balance.');
     }

     public function checkoutBids(Request $request)
     {
         $request->validate([
             'bid_pack' => 'required|integer|in:5,10,20',
             'payment_method' => 'required|exists:payment_methods,id',
         ]);

         $user = auth()->user();
         $packSize = $request->bid_pack;
         $cost = $packSize * 1; // $1 per bid

         // Here, integrate with payment gateway (e.g., Stripe)
         // For demo, assume payment succeeds
         $paymentMethod = \App\Modules\Payments\Models\PaymentMethod::find($request->payment_method);

         if ($paymentMethod && $paymentMethod->user_id == $user->id) {
             // Simulate payment processing
             // In real app, use Stripe::charge() or similar
             $paymentSuccess = true; // Assume success for demo

             if ($paymentSuccess) {
                 $user->addExtraBids($packSize);

                 // Optionally, create a transaction record
                 \App\Modules\Wallet\Models\WalletTransaction::create([
                     'wallet_id' => $user->wallet->id,
                     'type' => 'credit',
                     'amount' => $cost,
                     'description' => "Purchased {$packSize} extra bids",
                     'status' => 'completed',
                 ]);

                 return redirect()->route('freelancer.proposals.index')->with('success', "Successfully purchased {$packSize} extra bids via payment method.");
             }
         }

         return back()->with('error', 'Payment failed. Please try again.');
     }

     public function showBidCheckout($pack)
     {
         $validPacks = [5, 10, 20];
         if (!in_array($pack, $validPacks)) {
             abort(404);
         }

         $cost = $pack * 1; // $1 per bid
         $gateways = \App\Modules\Payments\Models\PaymentGateway::where('is_active', true)->get();

         return view('freelancer.bid-checkout', compact('pack', 'cost', 'gateways'));
     }

     public function processBidCheckout(Request $request, $pack)
     {
         $validPacks = [5, 10, 20];
         if (!in_array($pack, $validPacks)) {
             abort(404);
         }

         $request->validate([
             'gateway_id' => 'required|exists:payment_gateways,id',
             'terms' => 'accepted',
         ]);

         $user = auth()->user();
         $cost = $pack * 1;

         // Here, integrate with payment gateway
         $gateway = \App\Modules\Payments\Models\PaymentGateway::find($request->gateway_id);

         if ($gateway && $gateway->is_active) {
             // Simulate payment processing
             $paymentSuccess = true; // In real app, use gateway API

             if ($paymentSuccess) {
                 $user->addExtraBids($pack);

                 // Create transaction record
                 \App\Modules\Wallet\Models\WalletTransaction::create([
                     'wallet_id' => $user->wallet->id,
                     'type' => 'credit',
                     'amount' => $cost,
                     'description' => "Purchased {$pack} extra bids",
                     'status' => 'completed',
                 ]);

                 return redirect()->route('freelancer.proposals.index')->with('success', "Successfully purchased {$pack} extra bids.");
             }
         }

         return back()->with('error', 'Payment failed. Please try again.');
     }

     public function plans()
     {
         $plans = \App\Modules\Subscriptions\Models\SubscriptionPlan::where('plan_type', 'freelancer')
             ->where('is_active', true)
             ->get();

         return view('freelancer.plans', compact('plans'));
     }

     public function showPlanCheckout($planId)
     {
         $plan = \App\Modules\Subscriptions\Models\SubscriptionPlan::findOrFail($planId);
         $cost = $plan->price;
         $gateways = \App\Modules\Payments\Models\PaymentGateway::where('is_active', true)->get();

         return view('freelancer.plan-checkout', compact('plan', 'cost', 'gateways'));
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
         $existingSubscription = $user->activeFreelancerSubscription();
         if ($existingSubscription) {
             return back()->with('error', 'You already have an active freelancer subscription.');
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

                 return redirect()->route('freelancer.dashboard')->with('success', "Successfully subscribed to {$plan->name} plan.");
             }
         }

         return back()->with('error', 'Payment failed. Please try again.');
     }

     public function serviceOrders()
     {
         $orders = auth()->user()->ordersAsSeller()
             ->where('orderable_type', \App\Modules\Services\Models\Service::class)
             ->with(['buyer', 'service'])
             ->latest()
             ->paginate(10);

         return view('freelancer.service-orders', compact('orders'));
     }

     public function showServiceOrder(\App\Models\Order $order)
     {
         $order->load(['buyer', 'service']);

         return view('freelancer.service-order-show', compact('order'));
     }

     public function earnings()
     {
         $user = auth()->user();

         // Ensure wallet exists, create if not
         if (!$user->wallet) {
             $user->wallet()->create([
                 'balance' => 0.00,
                 'currency' => 'USD',
             ]);
             $user->load('wallet');
         }

         // Calculate total earnings from completed orders
         $totalEarnings = $user->ordersAsSeller()
             ->where('status', 'completed')
             ->sum('amount');

         // Calculate monthly earnings
         $monthlyEarnings = $user->ordersAsSeller()
             ->where('status', 'completed')
             ->whereYear('completed_at', now()->year)
             ->whereMonth('completed_at', now()->month)
             ->sum('amount');

         // Calculate pending earnings (in progress orders)
         $pendingEarnings = $user->ordersAsSeller()
             ->whereIn('status', ['pending', 'processing'])
             ->sum('amount');

         // Available balance from wallet
         $availableBalance = $user->wallet->balance;

         // Get recent transactions
         $transactions = \App\Modules\Wallet\Models\WalletTransaction::where('wallet_id', $user->wallet->id)
             ->latest()
             ->paginate(15);

         return view('freelancer.earnings', compact(
             'totalEarnings',
             'monthlyEarnings',
             'pendingEarnings',
             'availableBalance',
             'transactions'
         ));
     }
 }
