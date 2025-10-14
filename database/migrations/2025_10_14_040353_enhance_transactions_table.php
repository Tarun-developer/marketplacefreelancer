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
        Schema::table('transactions', function (Blueprint $table) {
            // Add payment gateway ID
            $table->foreignId('payment_gateway_id')->nullable()->after('gateway')->constrained('payment_gateways')->onDelete('set null');

            // Add payment method ID
            $table->foreignId('payment_method_id')->nullable()->after('payment_gateway_id')->constrained('payment_methods')->onDelete('set null');

            // Add fee tracking
            $table->decimal('fee_amount', 10, 2)->default(0)->after('amount');
            $table->decimal('net_amount', 10, 2)->after('fee_amount'); // Amount after fees

            // Add exchange rate for crypto/multi-currency
            $table->decimal('exchange_rate', 20, 8)->nullable()->after('currency');
            $table->string('original_currency', 10)->nullable()->after('exchange_rate');
            $table->decimal('original_amount', 15, 2)->nullable()->after('original_currency');

            // Add crypto-specific fields
            $table->string('crypto_address')->nullable()->after('gateway_transaction_id');
            $table->string('crypto_txn_hash')->nullable()->after('crypto_address');
            $table->integer('confirmations')->default(0)->after('crypto_txn_hash');
            $table->integer('required_confirmations')->default(0)->after('confirmations');

            // Add webhook data
            $table->json('webhook_data')->nullable()->after('metadata');
            $table->timestamp('webhook_received_at')->nullable()->after('webhook_data');

            // Add failure tracking
            $table->string('failure_code')->nullable()->after('status');
            $table->text('failure_message')->nullable()->after('failure_code');

            // Add IP and user agent for security
            $table->string('ip_address', 45)->nullable()->after('description');
            $table->text('user_agent')->nullable()->after('ip_address');

            // Add timestamps for different stages
            $table->timestamp('initiated_at')->nullable()->after('created_at');
            $table->timestamp('processed_at')->nullable()->after('initiated_at');
            $table->timestamp('completed_at')->nullable()->after('processed_at');
            $table->timestamp('failed_at')->nullable()->after('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['payment_gateway_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn([
                'payment_gateway_id',
                'payment_method_id',
                'fee_amount',
                'net_amount',
                'exchange_rate',
                'original_currency',
                'original_amount',
                'crypto_address',
                'crypto_txn_hash',
                'confirmations',
                'required_confirmations',
                'webhook_data',
                'webhook_received_at',
                'failure_code',
                'failure_message',
                'ip_address',
                'user_agent',
                'initiated_at',
                'processed_at',
                'completed_at',
                'failed_at',
            ]);
        });
    }
};
