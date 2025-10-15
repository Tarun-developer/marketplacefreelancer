<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    public function checkout($feature)
    {
        $user = Auth::user();

        // Define available features
        $features = [
            'spm' => [
                'name' => 'Simple Project Management (SPM)',
                'description' => 'Advanced project management tools',
                'cost' => config('settings.spm_subscription_cost', 29.99),
                'type' => 'subscription',
            ],
            'premium_bids' => [
                'name' => 'Premium Bids Package',
                'description' => 'Increase your bid limit',
                'cost' => config('settings.premium_bids_cost', 9.99),
                'type' => 'one-time',
            ],
            'verified_badge' => [
                'name' => 'Verified Badge',
                'description' => 'Get verified status',
                'cost' => config('settings.verified_badge_cost', 19.99),
                'type' => 'one-time',
            ],
            'featured_listing' => [
                'name' => 'Featured Listing',
                'description' => 'Get featured prominently',
                'cost' => config('settings.featured_listing_cost', 14.99),
                'type' => 'one-time',
            ],
        ];

        if (!isset($features[$feature])) {
            abort(404, 'Feature not found');
        }

        $featureData = $features[$feature];

        return view('checkout.feature', compact('feature', 'featureData'));
    }

    public function purchase(Request $request, $feature)
    {
        $user = Auth::user();

        // Validate payment method
        $request->validate([
            'payment_method' => 'required|in:stripe,paypal',
        ]);

        $features = [
            'spm' => [
                'name' => 'Simple Project Management (SPM)',
                'cost' => config('settings.spm_subscription_cost', 29.99),
                'type' => 'subscription',
            ],
            'premium_bids' => [
                'name' => 'Premium Bids Package',
                'cost' => config('settings.premium_bids_cost', 9.99),
                'type' => 'one-time',
            ],
            'verified_badge' => [
                'name' => 'Verified Badge',
                'cost' => config('settings.verified_badge_cost', 19.99),
                'type' => 'one-time',
            ],
            'featured_listing' => [
                'name' => 'Featured Listing',
                'cost' => config('settings.featured_listing_cost', 14.99),
                'type' => 'one-time',
            ],
        ];

        if (!isset($features[$feature])) {
            return response()->json(['error' => 'Feature not found'], 404);
        }

        $featureData = $features[$feature];

        // Process payment (simplified for demo)
        try {
            // Here you would integrate with payment gateway
            // For now, we'll simulate a successful payment

            if ($feature === 'spm') {
                // Grant SPM access
                $user->grantSpmAccess('premium', now()->addMonth());
                $message = 'SPM subscription activated successfully!';
            } elseif ($feature === 'premium_bids') {
                // Add extra bids
                $user->addExtraBids(50);
                $message = 'Premium bids package activated! You now have 50 additional bids.';
            } elseif ($feature === 'verified_badge') {
                // Mark as verified
                $user->profile()->update(['is_verified' => true]);
                $message = 'Verified badge activated! Your profile now shows as verified.';
            } elseif ($feature === 'featured_listing') {
                // Feature the user's services/products
                // This would require additional logic to feature items
                $message = 'Featured listing activated! Your items are now featured.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('dashboard')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Payment processing failed. Please try again.'
            ], 500);
        }
    }
}