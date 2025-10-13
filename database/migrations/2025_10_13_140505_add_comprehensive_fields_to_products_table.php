<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up(): void
     {
         Schema::table('products', function (Blueprint $table) {
             // Product Basics
             $table->text('short_description')->nullable()->after('description');
             $table->enum('product_type', ['script', 'plugin', 'template', 'graphic', 'course', 'service'])->default('script')->after('description');
             $table->json('tags')->nullable()->after('description');
             $table->string('demo_url')->nullable()->after('description');
             $table->string('documentation_url')->nullable()->after('demo_url');
             $table->string('video_preview')->nullable()->after('documentation_url');

             // Media Fields
             $table->string('thumbnail')->nullable()->after('video_preview');
             $table->json('screenshots')->nullable()->after('thumbnail');
             $table->string('main_file')->nullable()->after('screenshots');
             $table->string('preview_image')->nullable()->after('main_file');
             $table->string('file_type')->nullable()->after('preview_image');
             $table->bigInteger('file_size')->nullable()->after('file_type');

             // Pricing Tiers (extending existing price field)
             $table->decimal('standard_price', 10, 2)->nullable()->after('price');
             $table->decimal('professional_price', 10, 2)->nullable()->after('standard_price');
             $table->decimal('ultimate_price', 10, 2)->nullable()->after('professional_price');
             $table->decimal('discount_percentage', 5, 2)->default(0)->after('ultimate_price');
             $table->boolean('is_flash_sale')->default(false)->after('discount_percentage');
             $table->boolean('is_free')->default(false)->after('is_flash_sale');
             $table->boolean('money_back_guarantee')->default(false)->after('is_free');
             $table->integer('refund_days')->default(30)->after('money_back_guarantee');
             $table->text('refund_terms')->nullable()->after('refund_days');

             // Versioning
             $table->string('version')->default('1.0.0')->after('refund_terms');
             $table->date('release_date')->nullable()->after('version');
             $table->text('changelog')->nullable()->after('release_date');
             $table->boolean('feature_update_available')->default(false)->after('changelog');
             $table->boolean('item_support_available')->default(false)->after('feature_update_available');
             $table->enum('support_duration', ['6_months', '12_months', 'lifetime'])->default('6_months')->after('item_support_available');

             // SEO & Metadata
             $table->string('meta_title')->nullable()->after('support_duration');
             $table->text('meta_description')->nullable()->after('meta_title');
             $table->json('search_keywords')->nullable()->after('meta_description');
             $table->string('canonical_url')->nullable()->after('search_keywords');

             // Advanced Settings
             $table->string('compatible_with')->nullable()->after('canonical_url');
             $table->string('framework_technology')->nullable()->after('compatible_with');
             $table->json('files_included')->nullable()->after('framework_technology');
             $table->text('requirements')->nullable()->after('files_included');
             $table->boolean('license_agreement')->default(false)->after('requirements');
             $table->boolean('terms_of_upload')->default(false)->after('license_agreement');

             // Seller Information
             $table->string('author_name')->nullable()->after('terms_of_upload');
             $table->json('co_authors')->nullable()->after('author_name');
             $table->string('support_email')->nullable()->after('co_authors');
             $table->string('team_name')->nullable()->after('support_email');

             // Project Management Integration
             $table->foreignId('project_id')->nullable()->constrained('spm_projects')->onDelete('set null')->after('team_name');

             // Analytics
             $table->integer('estimated_delivery_time')->nullable()->after('project_id'); // in days
             $table->integer('views_count')->default(0)->after('estimated_delivery_time');
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('products', function (Blueprint $table) {
             // Remove all added columns in reverse order
             $table->dropColumn([
                 'views_count',
                 'estimated_delivery_time',
                 'project_id',
                 'team_name',
                 'support_email',
                 'co_authors',
                 'author_name',
                 'terms_of_upload',
                 'license_agreement',
                 'requirements',
                 'files_included',
                 'framework_technology',
                 'compatible_with',
                 'canonical_url',
                 'search_keywords',
                 'meta_description',
                 'meta_title',
                 'support_duration',
                 'item_support_available',
                 'feature_update_available',
                 'changelog',
                 'release_date',
                 'version',
                 'refund_terms',
                 'refund_days',
                 'money_back_guarantee',
                 'is_free',
                 'is_flash_sale',
                 'discount_percentage',
                 'ultimate_price',
                 'professional_price',
                 'standard_price',
                 'file_size',
                 'file_type',
                 'preview_image',
                 'main_file',
                 'screenshots',
                 'thumbnail',
                 'video_preview',
                 'documentation_url',
                 'demo_url',
                 'tags',
                 'product_type',
                 'short_description',
             ]);
         });
     }
};
