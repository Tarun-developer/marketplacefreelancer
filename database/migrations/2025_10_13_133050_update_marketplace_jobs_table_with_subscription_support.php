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
        Schema::table('marketplace_jobs', function (Blueprint $table) {
            // Fix duration to be string instead of integer
            $table->string('duration')->nullable()->change();

            // Add new fields for subscription and purchase support
            $table->enum('job_type', ['regular', 'support'])->default('regular')->after('status');
            $table->foreignId('product_id')->nullable()->after('job_type')->constrained('products')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->after('product_id')->constrained('orders')->onDelete('set null');
            $table->boolean('is_subscription_based')->default(false)->after('order_id');
            $table->integer('priority')->default(0)->after('is_subscription_based');

            // Add more status options
            $table->enum('status', ['draft', 'open', 'in_progress', 'completed', 'closed', 'cancelled'])->default('draft')->change();

            // Make expires_at nullable
            $table->timestamp('expires_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marketplace_jobs', function (Blueprint $table) {
            $table->dropColumn(['job_type', 'product_id', 'order_id', 'is_subscription_based', 'priority']);
        });
    }
};
