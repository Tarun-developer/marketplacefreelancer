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
         $this->call([
             RolePermissionSeeder::class,
             SubscriptionPlanSeeder::class,
             CategorySeeder::class,
             ProductSeeder::class,
         ]);

          // Seed users with different roles
          for ($i = 0; $i < 10; $i++) {
              $user = \App\Models\User::firstOrCreate(
                  ['email' => 'client' . ($i + 1) . '@example.com'],
                  [
                      'name' => 'Client ' . ($i + 1),
                      'password' => bcrypt('password'),
                      'role' => 'client',
                      'is_active' => true,
                  ]
              );
              $user->assignRole('client');
              $user->generateAvatar();
          }

          for ($i = 0; $i < 5; $i++) {
              $user = \App\Models\User::firstOrCreate(
                  ['email' => 'freelancer' . ($i + 1) . '@example.com'],
                  [
                      'name' => 'Freelancer ' . ($i + 1),
                      'password' => bcrypt('password'),
                      'role' => 'freelancer',
                      'is_active' => true,
                  ]
              );
              $user->assignRole('freelancer');
              $user->generateAvatar();
          }

          for ($i = 0; $i < 3; $i++) {
              $user = \App\Models\User::firstOrCreate(
                  ['email' => 'vendor' . ($i + 1) . '@example.com'],
                  [
                      'name' => 'Vendor ' . ($i + 1),
                      'password' => bcrypt('password'),
                      'role' => 'vendor',
                      'is_active' => true,
                  ]
              );
              $user->assignRole('vendor');
              $user->generateAvatar();
          }

          $admin = \App\Models\User::firstOrCreate(
              ['email' => 'admin@marketfusion.com'],
              [
                  'name' => 'Super Admin',
                  'password' => bcrypt('password'),
                  'role' => 'admin',
                  'is_active' => true,
                  'email_verified_at' => now(),
              ]
          );
          if (!$admin->hasRole('super_admin')) {
              $admin->assignRole('super_admin');
          }
          $admin->generateAvatar();

          $admin2 = \App\Models\User::firstOrCreate(
              ['email' => 'admin2@marketfusion.com'],
              [
                  'name' => 'Admin User',
                  'password' => bcrypt('password'),
                  'role' => 'admin',
                  'is_active' => true,
              ]
          );
          $admin2->assignRole('admin');
          $admin2->generateAvatar();

          $testUser = \App\Models\User::firstOrCreate(
              ['email' => 'test@example.com'],
              [
                  'name' => 'Test User',
                  'password' => bcrypt('password'),
                  'role' => 'client',
                  'is_active' => true,
              ]
          );
          $testUser->assignRole('client');
          $testUser->generateAvatar();

         // Create profiles for admin and test user
         $admin->profile()->create([
             'bio' => 'Super Administrator',
             'is_verified' => true,
         ]);

         $testUser->profile()->create([
             'bio' => 'Test Client',
         ]);

         // Create categories
         $categories = [];
         for ($i = 0; $i < 10; $i++) {
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
         for ($i = 0; $i < 20; $i++) {
             $tags[] = Tag::firstOrCreate(
                 ['slug' => 'tag-' . ($i + 1)],
                 [
                     'name' => 'Tag ' . ($i + 1),
                     'color' => '#000000',
                 ]
             );
         }

         // Seed products
         for ($i = 0; $i < 20; $i++) {
             $product = Product::firstOrCreate(
                 ['slug' => 'product-' . ($i + 1)],
                 [
                     'user_id' => $testUser->id,
                     'category_id' => $categories[array_rand($categories)]->id,
                     'name' => 'Product ' . ($i + 1),
                     'description' => 'Description for product ' . ($i + 1),
                     'price' => rand(10, 500),
                     'currency' => 'USD',
                     'license_type' => 'single',
                     'file_path' => '/files/product-' . ($i + 1) . '.zip',
                     'preview_images' => json_encode(['/images/product-' . ($i + 1) . '.jpg']),
                     'is_approved' => true,

                 ]
             );
             $randomTags = collect($tags)->random(3);
             $product->tags()->syncWithoutDetaching($randomTags->pluck('id'));
         }

         // Seed services
         for ($i = 0; $i < 15; $i++) {
              Service::firstOrCreate(
                  ['slug' => 'service-' . ($i + 1)],
                  [
                      'user_id' => $testUser->id,
                      'title' => 'Service ' . ($i + 1),
                      'description' => 'Description for service ' . ($i + 1),
                      'category_id' => $categories[array_rand($categories)]->id,
                      'price' => rand(10, 500),
                      'currency' => 'USD',
                      'delivery_time' => rand(1, 30),
                      'revisions' => 1,
                       'images' => json_encode(['/images/service-' . ($i + 1) . '.jpg']),
                      'is_active' => true,

                  ]
              );
         }

         // Create offers
         for ($i = 0; $i < 10; $i++) {
             Offer::firstOrCreate(
                 ['description' => 'Offer description ' . ($i + 1)],
                 [
                     'service_id' => Service::inRandomOrder()->first()->id,
                     'client_id' => $testUser->id,
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
                     'client_id' => $testUser->id,
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
             ['proposal' => 'Proposal for bid'],
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
                      'user_id' => $testUser->id,
                      'amount' => rand(10, 500),
                      'net_amount' => rand(10, 500) * 0.97, // Simulate fees
                      'currency' => 'USD',
                      'gateway' => 'stripe',
                      'status' => 'completed',
                      'type' => 'payment',
                      'description' => 'Payment for order ' . ($i + 1),
                  ]
              );
         }

         // Seed services
         for ($i = 0; $i < 15; $i++) {
              \App\Modules\Services\Models\Service::firstOrCreate(
                  ['slug' => 'service-' . ($i + 1)],
                  [
                       'user_id' => $testUser->id,
                      'title' => 'Service ' . ($i + 1),
                      'description' => 'Description for service ' . ($i + 1),
                      'category_id' => $categories[array_rand($categories)]->id,
                      'price' => rand(10, 500),
                      'currency' => 'USD',
                      'delivery_time' => rand(1, 30),
                      'revisions' => 1,
                       'images' => json_encode(['/images/service-' . ($i + 1) . '.jpg']),
                      'is_active' => true,

                  ]
              );
         }

         // Seed jobs
         for ($i = 0; $i < 10; $i++) {
             \App\Modules\Jobs\Models\Job::firstOrCreate(
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

         // Seed tags
         for ($i = 0; $i < 20; $i++) {
             \App\Modules\Products\Models\Tag::firstOrCreate(
                 ['slug' => 'tag-' . ($i + 1)],
                 [
                     'name' => 'Tag ' . ($i + 1),
                     'color' => '#000000',
                 ]
             );
         }

         // Seed support tickets
         for ($i = 0; $i < 10; $i++) {
             \App\Modules\Support\Models\SupportTicket::firstOrCreate(
                 ['subject' => 'Support Ticket ' . ($i + 1)],
                 [
                     'user_id' => $testUser->id,
                     'category' => 'general',
                     'priority' => 'medium',
                     'message' => 'Description for support ticket ' . ($i + 1),
                     'status' => 'open',
                 ]
             );
         }

          // Seed reviews
          // Commented out for now
          /*
          for ($i = 0; $i < 20; $i++) {
              \App\Modules\Reviews\Models\Review::firstOrCreate(
                  ['comment' => 'Review ' . ($i + 1)],
                  [
                      'reviewer_id' => $testUser->id,
                      'reviewee_id' => $admin->id,
                      'order_id' => 1, // Use a fixed order_id
                      'rating' => rand(1, 5),
                      'type' => 'product',
                  ]
              );
          }
          */

          // Seed transactions
         for ($i = 0; $i < 15; $i++) {
              \App\Modules\Payments\Models\Transaction::firstOrCreate(
                  ['gateway_transaction_id' => 'txn_' . ($i + 1)],
                  [
                       'user_id' => $testUser->id,
                      'amount' => rand(10, 500),
                      'net_amount' => rand(10, 500) * 0.97, // Simulate fees
                      'currency' => 'USD',
                      'gateway' => 'stripe',
                      'status' => 'completed',
                      'type' => 'payment',
                      'description' => 'Payment for order ' . ($i + 1),
                  ]
              );
         }

         // Seed orders
         $orders = [];
         for ($i = 0; $i < 10; $i++) {
             $orders[] = \App\Modules\Orders\Models\Order::create(
                 [
                     'buyer_id' => $testUser->id,
                     'seller_id' => $admin->id,
                     'orderable_type' => 'App\Modules\Products\Models\Product',
                     'orderable_id' => 1, // Use a fixed product_id
                     'amount' => rand(10, 500),
                     'currency' => 'USD',
                     'status' => 'completed',
                     'payment_status' => 'paid',
                 ]
             );
         }

          // Seed reviews
          // Commented out for now
          /*
          for ($i = 0; $i < 10; $i++) {
              \App\Modules\Reviews\Models\Review::create(
                  [
                      'reviewer_id' => $testUser->id,
                      'reviewee_id' => $admin->id,
                      'order_id' => $orders[$i % 10]->id, // Use different order_ids
                      'rating' => rand(1, 5),
                      'type' => 'product',
                  ]
              );
          }
          */

          // Seed reviews
          // Commented out for now
          /*
          for ($i = 0; $i < 20; $i++) {
              \App\Modules\Reviews\Models\Review::firstOrCreate(
                  ['comment' => 'Review ' . ($i + 1)],
                  [
                      'reviewer_id' => $testUser->id,
                      'reviewee_id' => $admin->id,
                      'order_id' => 1, // Use a fixed order_id
                      'rating' => rand(1, 5),
                      'type' => 'product',
                  ]
              );
          }
          */

         // Seed disputes
         for ($i = 0; $i < 5; $i++) {
             \App\Modules\Disputes\Models\Dispute::firstOrCreate(
                 ['description' => 'Dispute ' . ($i + 1)],
                 [
                     'order_id' => $orders[$i % 10]->id,
                     'raised_by' => $testUser->id,
                     'reason' => 'delivery',
                     'description' => 'Reason for dispute ' . ($i + 1),
                     'status' => 'open',
                 ]
             );
         }

         // Seed conversations
         for ($i = 0; $i < 10; $i++) {
             \App\Modules\Chat\Models\Conversation::firstOrCreate(
                 ['title' => 'Conversation ' . ($i + 1)],
                 [
                     'type' => 'direct',

                 ]
             );
         }

         // Seed messages
         for ($i = 0; $i < 50; $i++) {
             \App\Modules\Chat\Models\Message::firstOrCreate(
                 ['message' => 'Message ' . ($i + 1)],
                 [
                     'conversation_id' => \App\Modules\Chat\Models\Conversation::inRandomOrder()->first()->id,
                     'user_id' => $testUser->id,
                     'is_read' => false,
                 ]
             );
         }

          // Seed disputes
          for ($i = 0; $i < 5; $i++) {
              \App\Modules\Disputes\Models\Dispute::firstOrCreate(
                  ['description' => 'Dispute ' . ($i + 1)],
                  [
                      'order_id' => $orders[$i % 10]->id,
                      'raised_by' => $testUser->id,
                      'reason' => 'delivery',
                      'description' => 'Reason for dispute ' . ($i + 1),
                      'status' => 'open',
                  ]
              );
          }

         // Seed conversations
         for ($i = 0; $i < 10; $i++) {
             \App\Modules\Chat\Models\Conversation::firstOrCreate(
                 ['title' => 'Conversation ' . ($i + 1)],
                 [
                     'type' => 'direct',

                 ]
             );
         }

         // Seed messages
         for ($i = 0; $i < 50; $i++) {
             \App\Modules\Chat\Models\Message::firstOrCreate(
                 ['message' => 'Message ' . ($i + 1)],
                 [
                     'conversation_id' => \App\Modules\Chat\Models\Conversation::inRandomOrder()->first()->id,
                      'user_id' => $testUser->id,
                     'is_read' => false,
                 ]
             );
         }

         // Seed wallets
         \App\Models\User::all()->each(function ($user) {
             \App\Modules\Wallet\Models\Wallet::firstOrCreate(
                 ['user_id' => $user->id],
                 [
                     'balance' => 0.00,
                     'currency' => 'USD',
                 ]
             );
         });

         // Seed wallet transactions
         for ($i = 0; $i < 30; $i++) {
             \App\Modules\Wallet\Models\WalletTransaction::create(
                 [
                     'wallet_id' => \App\Modules\Wallet\Models\Wallet::inRandomOrder()->first()->id,
                     'amount' => rand(10, 500),
                     'currency' => 'USD',
                     'type' => 'credit',
                     'description' => 'Wallet transaction ' . ($i + 1),
                 ]
             );
         }
     }
 }
