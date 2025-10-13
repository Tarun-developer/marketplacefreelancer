<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get some users to assign as vendors
        $vendors = User::where('role', 'vendor')->take(5)->get();

        if ($vendors->isEmpty()) {
            // Create some vendor users if none exist
            $vendors = collect();
            for ($i = 0; $i < 5; $i++) {
                $user = User::create([
                    'name' => 'Vendor ' . ($i + 1),
                    'email' => 'vendor' . ($i + 1) . '@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'vendor',
                    'email_verified_at' => now(),
                ]);
                $vendors->push($user);
            }
        }

        $products = [
            [
                'name' => 'Modern Business WordPress Theme',
                'slug' => 'modern-business-wordpress-theme',
                'short_description' => 'Professional WordPress theme for business websites',
                'description' => '<h2>Modern Business WordPress Theme</h2><p>A sleek and professional WordPress theme designed for modern businesses. Features responsive design, SEO optimization, and easy customization.</p><h3>Features:</h3><ul><li>Responsive Design</li><li>SEO Optimized</li><li>Custom Widgets</li><li>One-Click Demo Import</li><li>Premium Support</li></ul>',
                'product_type' => 'template',
                'category_id' => 1, // WordPress Themes
                'user_id' => $vendors->random()->id,
                'price' => 49.00,
                'standard_price' => 49.00,
                'professional_price' => 99.00,
                'ultimate_price' => 199.00,
                'version' => '1.2.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => true,
                'thumbnail' => 'product-thumbnails/theme1.jpg',
                'screenshots' => ['product-screenshots/theme1-1.jpg', 'product-screenshots/theme1-2.jpg'],
                'file_path' => 'product-files/theme1.zip',
                'file_size' => 5242880, // 5MB
                'tags' => ['wordpress', 'business', 'responsive', 'modern'],
                'demo_url' => 'https://demo.example.com/theme1',
                'documentation_url' => 'https://docs.example.com/theme1',
                'compatible_with' => 'WordPress 6.0+',
                'requirements' => 'PHP 7.4+, MySQL 5.7+',
                'files_included' => ['PHP Files', 'CSS Files', 'JS Files', 'Documentation'],
                'author_name' => 'ThemeMaster',
                'support_email' => 'support@thememaster.com',
            ],
            [
                'name' => 'Advanced PHP User Management System',
                'slug' => 'advanced-php-user-management-system',
                'short_description' => 'Complete user management system with roles and permissions',
                'description' => '<h2>Advanced PHP User Management System</h2><p>A comprehensive PHP script for user management with advanced features including roles, permissions, and multi-factor authentication.</p><h3>Features:</h3><ul><li>Role-based Access Control</li><li>Multi-factor Authentication</li><li>Email Verification</li><li>Password Reset</li><li>Audit Logging</li></ul>',
                'product_type' => 'script',
                'category_id' => 2, // PHP Scripts
                'user_id' => $vendors->random()->id,
                'price' => 79.00,
                'standard_price' => 79.00,
                'professional_price' => 149.00,
                'ultimate_price' => 299.00,
                'version' => '2.1.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => false,
                'thumbnail' => 'product-thumbnails/script1.jpg',
                'screenshots' => ['product-screenshots/script1-1.jpg', 'product-screenshots/script1-2.jpg'],
                'file_path' => 'product-files/script1.zip',
                'file_size' => 2097152, // 2MB
                'tags' => ['php', 'user-management', 'authentication', 'security'],
                'demo_url' => 'https://demo.example.com/script1',
                'documentation_url' => 'https://docs.example.com/script1',
                'compatible_with' => 'PHP 7.4+, MySQL 5.7+',
                'requirements' => 'PHP 7.4+, MySQL 5.7+, cURL extension',
                'files_included' => ['PHP Files', 'SQL Files', 'Documentation'],
                'author_name' => 'CodeWizard',
                'support_email' => 'support@codewizard.com',
            ],
            [
                'name' => 'React Dashboard Template',
                'slug' => 'react-dashboard-template',
                'short_description' => 'Modern React dashboard with charts and components',
                'description' => '<h2>React Dashboard Template</h2><p>A beautiful and responsive React dashboard template with pre-built components, charts, and dark mode support.</p><h3>Features:</h3><ul><li>Responsive Design</li><li>Dark Mode</li><li>Chart.js Integration</li><li>Modular Components</li><li>TypeScript Support</li></ul>',
                'product_type' => 'template',
                'category_id' => 7, // React
                'user_id' => $vendors->random()->id,
                'price' => 39.00,
                'standard_price' => 39.00,
                'professional_price' => 79.00,
                'ultimate_price' => 159.00,
                'version' => '1.5.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => true,
                'thumbnail' => 'product-thumbnails/react1.jpg',
                'screenshots' => ['product-screenshots/react1-1.jpg', 'product-screenshots/react1-2.jpg'],
                'file_path' => 'product-files/react1.zip',
                'file_size' => 3145728, // 3MB
                'tags' => ['react', 'dashboard', 'typescript', 'charts'],
                'demo_url' => 'https://demo.example.com/react1',
                'documentation_url' => 'https://docs.example.com/react1',
                'compatible_with' => 'React 18+, Node.js 16+',
                'requirements' => 'Node.js 16+, npm or yarn',
                'files_included' => ['JS Files', 'CSS Files', 'Documentation'],
                'author_name' => 'ReactPro',
                'support_email' => 'support@reactpro.com',
            ],
            [
                'name' => 'Laravel E-commerce Package',
                'slug' => 'laravel-ecommerce-package',
                'short_description' => 'Complete e-commerce solution for Laravel applications',
                'description' => '<h2>Laravel E-commerce Package</h2><p>A comprehensive e-commerce package for Laravel with shopping cart, payment integration, and admin panel.</p><h3>Features:</h3><ul><li>Shopping Cart</li><li>Payment Gateways</li><li>Order Management</li><li>Inventory Tracking</li><li>Admin Dashboard</li></ul>',
                'product_type' => 'plugin',
                'category_id' => 6, // Laravel
                'user_id' => $vendors->random()->id,
                'price' => 99.00,
                'standard_price' => 99.00,
                'professional_price' => 199.00,
                'ultimate_price' => 399.00,
                'version' => '3.0.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => false,
                'thumbnail' => 'product-thumbnails/laravel1.jpg',
                'screenshots' => ['product-screenshots/laravel1-1.jpg', 'product-screenshots/laravel1-2.jpg'],
                'file_path' => 'product-files/laravel1.zip',
                'file_size' => 4194304, // 4MB
                'tags' => ['laravel', 'ecommerce', 'php', 'package'],
                'demo_url' => 'https://demo.example.com/laravel1',
                'documentation_url' => 'https://docs.example.com/laravel1',
                'compatible_with' => 'Laravel 9+, PHP 8.1+',
                'requirements' => 'Laravel 9+, PHP 8.1+, Composer',
                'files_included' => ['PHP Files', 'Migrations', 'Documentation'],
                'author_name' => 'LaravelExpert',
                'support_email' => 'support@laravel-expert.com',
            ],
            [
                'name' => 'Vue.js Admin Dashboard',
                'slug' => 'vuejs-admin-dashboard',
                'short_description' => 'Feature-rich Vue.js admin dashboard with charts',
                'description' => '<h2>Vue.js Admin Dashboard</h2><p>A powerful Vue.js admin dashboard with charts, tables, and modern UI components.</p><h3>Features:</h3><ul><li>Vue 3 Compatible</li><li>Chart.js Integration</li><li>Responsive Design</li><li>Dark Mode</li><li>Modular Architecture</li></ul>',
                'product_type' => 'template',
                'category_id' => 8, // Vue.js
                'user_id' => $vendors->random()->id,
                'price' => 59.00,
                'standard_price' => 59.00,
                'professional_price' => 119.00,
                'ultimate_price' => 239.00,
                'version' => '2.3.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => false,
                'thumbnail' => 'product-thumbnails/vue1.jpg',
                'screenshots' => ['product-screenshots/vue1-1.jpg', 'product-screenshots/vue1-2.jpg'],
                'file_path' => 'product-files/vue1.zip',
                'file_size' => 2621440, // 2.5MB
                'tags' => ['vuejs', 'dashboard', 'admin', 'charts'],
                'demo_url' => 'https://demo.example.com/vue1',
                'documentation_url' => 'https://docs.example.com/vue1',
                'compatible_with' => 'Vue 3+, Node.js 16+',
                'requirements' => 'Node.js 16+, Vue CLI',
                'files_included' => ['Vue Files', 'CSS Files', 'Documentation'],
                'author_name' => 'VueMaster',
                'support_email' => 'support@vuemaster.com',
            ],
            [
                'name' => 'Professional Logo Design Package',
                'slug' => 'professional-logo-design-package',
                'short_description' => 'Complete logo design package with multiple formats',
                'description' => '<h2>Professional Logo Design Package</h2><p>A complete logo design package including multiple file formats, color variations, and brand guidelines.</p><h3>Includes:</h3><ul><li>High-resolution PNG files</li><li>Vector SVG files</li><li>AI and EPS source files</li><li>Brand guidelines PDF</li><li>Multiple color variations</li></ul>',
                'product_type' => 'graphic',
                'category_id' => 5, // Graphics & Design
                'user_id' => $vendors->random()->id,
                'price' => 149.00,
                'standard_price' => 149.00,
                'professional_price' => 299.00,
                'ultimate_price' => 599.00,
                'version' => '1.0.0',
                'status' => 'active',
                'is_approved' => true,
                'is_featured' => true,
                'thumbnail' => 'product-thumbnails/logo1.jpg',
                'screenshots' => ['product-screenshots/logo1-1.jpg', 'product-screenshots/logo1-2.jpg'],
                'file_path' => 'product-files/logo1.zip',
                'file_size' => 10485760, // 10MB
                'tags' => ['logo', 'branding', 'design', 'vector'],
                'demo_url' => 'https://demo.example.com/logo1',
                'documentation_url' => 'https://docs.example.com/logo1',
                'compatible_with' => 'Adobe Illustrator, Photoshop',
                'requirements' => 'Design software to edit source files',
                'files_included' => ['AI Files', 'EPS Files', 'PNG Files', 'PDF Files'],
                'author_name' => 'DesignStudio',
                'support_email' => 'support@designstudio.com',
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::firstOrCreate(['slug' => $productData['slug']], $productData);

            // Create initial version
            $product->versions()->create([
                'version_number' => $product->version,
                'changelog' => 'Initial release',
                'release_date' => now(),
                'file_path' => $product->file_path,
                'file_size' => $product->file_size,
                'is_active' => true,
            ]);

            // Note: current_version_id relationship is handled by the model
        }
    }
}