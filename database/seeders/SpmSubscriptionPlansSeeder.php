<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Subscriptions\Models\SubscriptionPlan;

class SpmSubscriptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spmPlans = [
            [
                'name' => 'SPM Free',
                'description' => 'Limited SPM access for testing',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_period' => 'monthly',
                'features' => [
                    '1 active project',
                    '10 tasks per project',
                    'Basic time tracking',
                    '100MB file storage',
                    'Email notifications',
                ],
                'is_active' => true,
                 'max_bids' => 100,
                'max_products' => null,
                 'max_services' => 100,
                'priority_support' => false,
                'featured_listings' => false,
                'plan_type' => 'spm',
                'spm_max_projects' => 1,
                'spm_max_tasks_per_project' => 10,
                'spm_storage_gb' => 0.1,
                'spm_has_reports' => false,
                'spm_has_api' => false,
            ],
            [
                'name' => 'SPM Basic',
                'description' => 'Essential project management tools for growing teams',
                'price' => 9.99,
                'currency' => 'USD',
                'billing_period' => 'monthly',
                'features' => [
                    '5 active projects',
                    'Unlimited tasks',
                    'Full time tracking with approval',
                    '1GB file storage',
                    'Email notifications',
                    'Task comments and mentions',
                    'Milestone management',
                ],
                'is_active' => true,
                 'max_bids' => 100,
                'max_products' => null,
                 'max_services' => 100,
                'priority_support' => false,
                'featured_listings' => false,
                'plan_type' => 'spm',
                'spm_max_projects' => 5,
                'spm_max_tasks_per_project' => null,
                'spm_storage_gb' => 1,
                'spm_has_reports' => false,
                'spm_has_api' => false,
            ],
            [
                'name' => 'SPM Pro',
                'description' => 'Advanced features for professional project management',
                'price' => 29.99,
                'currency' => 'USD',
                'billing_period' => 'monthly',
                'features' => [
                    'Unlimited projects',
                    'Unlimited tasks',
                    'Advanced time tracking',
                    'Advanced reporting',
                    'Priority support',
                    '10GB file storage',
                    'API access',
                    'Custom branding',
                    'Gantt charts',
                    'Export to PDF',
                ],
                'is_active' => true,
                 'max_bids' => 100,
                'max_products' => null,
                 'max_services' => 100,
                'priority_support' => true,
                'featured_listings' => false,
                'plan_type' => 'spm',
                'spm_max_projects' => null,
                'spm_max_tasks_per_project' => null,
                'spm_storage_gb' => 10,
                'spm_has_reports' => true,
                'spm_has_api' => true,
            ],
            [
                'name' => 'SPM Enterprise',
                'description' => 'Complete solution for large organizations',
                'price' => 99.99,
                'currency' => 'USD',
                'billing_period' => 'monthly',
                'features' => [
                    'Everything in Pro',
                    'Dedicated account manager',
                    'Custom integrations',
                    '100GB file storage',
                    'White-label option',
                    'Multi-team management',
                    'SLA guarantee',
                    'Custom workflows',
                    'Advanced security features',
                    '24/7 phone support',
                ],
                'is_active' => true,
                 'max_bids' => 100,
                'max_products' => null,
                 'max_services' => 100,
                'priority_support' => true,
                'featured_listings' => false,
                'plan_type' => 'spm',
                'spm_max_projects' => null,
                'spm_max_tasks_per_project' => null,
                'spm_storage_gb' => 100,
                'spm_has_reports' => true,
                'spm_has_api' => true,
            ],
        ];

        foreach ($spmPlans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }

         // Freelancer Plans
         $freelancerPlans = [
             [
                 'name' => 'Freelancer Free',
                 'description' => 'Basic freelancing with limited bids',
                 'price' => 0.00,
                 'currency' => 'USD',
                 'billing_period' => 'monthly',
                 'features' => [
                     '5 bids per month',
                     'Basic profile',
                     'Job browsing',
                     'Proposal submission',
                 ],
                 'is_active' => true,
                 'max_bids' => 5,
                 'max_products' => null,
                 'max_services' => 5,
                 'priority_support' => false,
                 'featured_listings' => false,
                 'plan_type' => 'freelancer',
             ],
             [
                 'name' => 'Freelancer Basic',
                 'description' => 'Enhanced freelancing tools',
                 'price' => 9.99,
                 'currency' => 'USD',
                 'billing_period' => 'monthly',
                 'features' => [
                     '20 bids per month',
                     'Enhanced profile',
                     'Priority in search',
                     'Advanced analytics',
                 ],
                 'is_active' => true,
                 'max_bids' => 20,
                 'max_products' => null,
                 'max_services' => 5,
                 'priority_support' => false,
                 'featured_listings' => false,
                 'plan_type' => 'freelancer',
             ],
             [
                 'name' => 'Freelancer Pro',
                 'description' => 'Professional freelancing features',
                 'price' => 29.99,
                 'currency' => 'USD',
                 'billing_period' => 'monthly',
                 'features' => [
                     '50 bids per month',
                     'Premium profile',
                     'Featured listings',
                     'Priority support',
                     'Advanced tools',
                 ],
                 'is_active' => true,
                 'max_bids' => 50,
                 'max_products' => null,
                 'max_services' => 5,
                 'priority_support' => true,
                 'featured_listings' => true,
                 'plan_type' => 'freelancer',
             ],
             [
                 'name' => 'Freelancer Enterprise',
                 'description' => 'Complete freelancing solution',
                 'price' => 99.99,
                 'currency' => 'USD',
                 'billing_period' => 'monthly',
                 'features' => [
                     '100 bids per month',
                     'Custom profile',
                     'Dedicated support',
                     'API access',
                     'White-label options',
                 ],
                 'is_active' => true,
                 'max_bids' => 100,
                 'max_products' => null,
                 'max_services' => 5,
                 'priority_support' => true,
                 'featured_listings' => true,
                 'plan_type' => 'freelancer',
             ],
         ];

         foreach ($freelancerPlans as $plan) {
             SubscriptionPlan::firstOrCreate(
                 ['name' => $plan['name']],
                 $plan
             );
         }

         $this->command->info('SPM and Freelancer Subscription Plans created successfully!');
    }
}
