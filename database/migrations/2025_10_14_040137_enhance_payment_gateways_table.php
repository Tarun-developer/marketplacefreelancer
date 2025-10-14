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
        Schema::table('payment_gateways', function (Blueprint $table) {
            // Add gateway type
            $table->enum('type', ['fiat', 'crypto', 'wallet'])->default('fiat')->after('slug');

            // Add description
            $table->text('description')->nullable()->after('type');

            // Add logo/icon
            $table->string('logo')->nullable()->after('description');

            // Add supported currencies (JSON array)
            $table->json('supported_currencies')->nullable()->after('logo');

            // Add supported countries (JSON array)
            $table->json('supported_countries')->nullable()->after('supported_currencies');

            // Add transaction fees
            $table->decimal('transaction_fee_percentage', 5, 2)->default(0)->after('supported_countries');
            $table->decimal('transaction_fee_fixed', 10, 2)->default(0)->after('transaction_fee_percentage');
            $table->string('transaction_fee_currency', 3)->default('USD')->after('transaction_fee_fixed');

            // Add minimum and maximum amounts
            $table->decimal('min_amount', 15, 2)->nullable()->after('transaction_fee_currency');
            $table->decimal('max_amount', 15, 2)->nullable()->after('min_amount');

            // Add processing time (in minutes)
            $table->integer('processing_time_minutes')->nullable()->after('max_amount');

            // Add webhook settings
            $table->string('webhook_url')->nullable()->after('processing_time_minutes');
            $table->string('webhook_secret')->nullable()->after('webhook_url');

            // Add test mode
            $table->boolean('test_mode')->default(false)->after('webhook_secret');

            // Add sandbox credentials (JSON)
            $table->json('sandbox_config')->nullable()->after('test_mode');

            // Add sort order for display
            $table->integer('sort_order')->default(0)->after('sandbox_config');

            // Add instructions for users
            $table->text('user_instructions')->nullable()->after('sort_order');

            // Add admin notes (private)
            $table->text('admin_notes')->nullable()->after('user_instructions');

            // Add status tracking
            $table->timestamp('last_used_at')->nullable()->after('is_active');
            $table->integer('total_transactions')->default(0)->after('last_used_at');
            $table->decimal('total_volume', 20, 2)->default(0)->after('total_transactions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_gateways', function (Blueprint $table) {
            $table->dropColumn([
                'type',
                'description',
                'logo',
                'supported_currencies',
                'supported_countries',
                'transaction_fee_percentage',
                'transaction_fee_fixed',
                'transaction_fee_currency',
                'min_amount',
                'max_amount',
                'processing_time_minutes',
                'webhook_url',
                'webhook_secret',
                'test_mode',
                'sandbox_config',
                'sort_order',
                'user_instructions',
                'admin_notes',
                'last_used_at',
                'total_transactions',
                'total_volume',
            ]);
        });
    }
};
