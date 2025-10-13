<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Tag;
use App\Modules\Products\Models\Product;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\Offer;
use App\Modules\Jobs\Models\Job;
use App\Modules\Jobs\Models\Bid;
use App\Modules\Payments\Models\Transaction;
use App\Modules\Payments\Models\PaymentGateway;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
     /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Create roles
         foreach (UserRole::cases() as $role) {
             Role::firstOrCreate(['name' => $role->value]);
         }

         // Create permissions (example)
         Permission::firstOrCreate(['name' => 'edit-product']);
         Permission::firstOrCreate(['name' => 'delete-product']);
         Permission::firstOrCreate(['name' => 'manage-users']);

         // Create admin user
         $admin = User::firstOrCreate(
             ['email' => 'admin@marketfusion.com'],
             [
                 'name' => 'Super Admin',
                 'password' => bcrypt('password'),
                 'role' => 'admin',
                 'is_active' => true,
             ]
         );
         $admin->assignRole(UserRole::SUPER_ADMIN->value);

         // Create test user
         $user = User::firstOrCreate(
             ['email' => 'test@example.com'],
             [
                 'name' => 'Test User',
                 'password' => bcrypt('password'),
                 'role' => 'client',
                 'is_active' => true,
             ]
         );
         $user->assignRole(UserRole::CLIENT->value);

         // Create profiles and KYC for users
         $admin->profile()->create([
             'bio' => 'Super Administrator',
             'is_verified' => true,
         ]);

         $user->profile()->create([
             'bio' => 'Test Client',
         ]);

         // Create categories
         $categories = [];
         for ($i = 0; $i < 5; $i++) {
             $categories[] = Category::firstOrCreate(
                 ['slug' => 'category-' . ($i + 1)],
                 [
                     'name' => 'Category ' . ($i + 1),
                     'description' => 'Description for category ' . ($i + 1),
                     'is_active' => true,
                     'commission_rate' => 15.00,
                 ]
             );
         }

         // Create tags
         $tags = [];
         for ($i = 0; $i < 10; $i++) {
             $tags[] = Tag::firstOrCreate(
                 ['slug' => 'tag-' . ($i + 1)],
                 [
                     'name' => 'Tag ' . ($i + 1),
                     'color' => '#000000',
                 ]
             );
         }

         // Create products
         for ($i = 0; $i < 20; $i++) {
             $product = Product::firstOrCreate(
                 ['slug' => 'product-' . ($i + 1)],
                 [
                     'user_id' => $user->id,
                     'category_id' => $categories[array_rand($categories)]->id,
                     'name' => 'Product ' . ($i + 1),
                     'description' => 'Description for product ' . ($i + 1),
                     'price' => rand(10, 500),
                     'currency' => 'USD',
                     'license_type' => 'single',
                     'file_path' => '/files/product-' . ($i + 1) . '.zip',
                     'preview_images' => ['/images/product-' . ($i + 1) . '.jpg'],
                     'is_approved' => true,
                     'status' => 'active',
                 ]
             );
             $randomTags = collect($tags)->random(3);
             $product->tags()->syncWithoutDetaching($randomTags->pluck('id'));
         }

         // Create services
         for ($i = 0; $i < 15; $i++) {
             Service::firstOrCreate(
                 ['slug' => 'service-' . ($i + 1)],
                 [
                     'user_id' => $user->id,
                     'title' => 'Service ' . ($i + 1),
                     'description' => 'Description for service ' . ($i + 1),
                     'category' => 'General',
                     'price' => rand(10, 500),
                     'currency' => 'USD',
                     'delivery_time' => rand(1, 30),
                     'revisions' => 1,
                     'images' => ['/images/service-' . ($i + 1) . '.jpg'],
                     'is_active' => true,
                     'status' => 'active',
                 ]
             );
         }

         // Create offers
         for ($i = 0; $i < 10; $i++) {
             Offer::firstOrCreate(
                 ['description' => 'Offer description ' . ($i + 1)],
                 [
                     'service_id' => Service::inRandomOrder()->first()->id,
                     'client_id' => $user->id,
                     'freelancer_id' => $admin->id,
                     'price' => rand(10, 500),
                     'currency' => 'USD',
                     'delivery_time' => rand(1, 30),
                     'status' => 'pending',
                     'expires_at' => now()->addDays(7),
                 ]
             );
         }

         // Create jobs
         for ($i = 0; $i < 10; $i++) {
             Job::firstOrCreate(
                 ['slug' => 'job-' . ($i + 1)],
                 [
                     'client_id' => $user->id,
                     'title' => 'Job ' . ($i + 1),
                     'description' => 'Description for job ' . ($i + 1),
                     'category' => 'General',
                     'budget_min' => rand(100, 500),
                     'budget_max' => rand(500, 2000),
                     'currency' => 'USD',
                     'duration' => rand(1, 30),
                     'skills_required' => ['skill1', 'skill2'],
                     'status' => 'open',
                     'expires_at' => now()->addDays(30),
                 ]
             );
         }

         // Create bids
         Bid::firstOrCreate(
             ['proposal' => 'Proposal for bid ' . ($i + 1)],
             [
                 'job_id' => Job::inRandomOrder()->first()->id,
                 'freelancer_id' => $admin->id,
                 'price' => rand(100, 1000),
                 'currency' => 'USD',
                 'duration' => rand(1, 30),
                 'status' => 'pending',
             ]
         );

         // Create payment gateways
         PaymentGateway::firstOrCreate(['slug' => 'stripe'], ['name' => 'Stripe', 'is_active' => true]);
         PaymentGateway::firstOrCreate(['slug' => 'paypal'], ['name' => 'PayPal', 'is_active' => true]);
         PaymentGateway::firstOrCreate(['slug' => 'razorpay'], ['name' => 'Razorpay', 'is_active' => true]);

         // Create transactions
         for ($i = 0; $i < 10; $i++) {
             Transaction::firstOrCreate(
                 ['gateway_transaction_id' => 'txn_' . ($i + 1)],
                 [
                     'user_id' => $user->id,
                     'amount' => rand(10, 500),
                     'currency' => 'USD',
                     'gateway' => 'stripe',
                     'status' => 'completed',
                     'type' => 'payment',
                     'description' => 'Payment for order ' . ($i + 1),
                 ]
          );

          // Seed subscription plans
          $this->call(SubscriptionPlanSeeder::class);
      }
}
     }
}
