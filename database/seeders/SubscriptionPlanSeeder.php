<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Freelancer Basic',
                'description' => 'Basic plan for freelancers',
                'price' => 9.99,
                'billing_period' => 'monthly',
                'features' => ['5 bids per month', 'Basic support'],
                'max_bids' => 5,
                'max_products' => 0,
                'max_services' => 10,
                'priority_support' => false,
                'featured_listings' => false,
            ],
            [
                'name' => 'Freelancer Pro',
                'description' => 'Pro plan for freelancers',
                'price' => 19.99,
                'billing_period' => 'monthly',
                'features' => ['Unlimited bids', 'Priority support', 'Featured listings'],
                'max_bids' => null,
                'max_products' => 0,
                'max_services' => 50,
                'priority_support' => true,
                'featured_listings' => true,
            ],
            [
                'name' => 'Vendor Basic',
                'description' => 'Basic plan for vendors',
                'price' => 14.99,
                'billing_period' => 'monthly',
                'features' => ['10 products', 'Basic support'],
                'max_bids' => 0,
                'max_products' => 10,
                'max_services' => 0,
                'priority_support' => false,
                'featured_listings' => false,
            ],
            [
                'name' => 'Vendor Pro',
                'description' => 'Pro plan for vendors',
                'price' => 29.99,
                'billing_period' => 'monthly',
                'features' => ['Unlimited products', 'Priority support', 'Featured listings'],
                'max_bids' => 0,
                'max_products' => null,
                'max_services' => 0,
                'priority_support' => true,
                'featured_listings' => true,
            ],
        ];

        foreach ($plans as $plan) {
            \App\Modules\Subscriptions\Models\SubscriptionPlan::create($plan);
        }
    }
}
