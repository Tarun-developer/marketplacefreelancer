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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('billing_period', ['monthly', 'yearly'])->default('monthly');
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('max_bids')->nullable();
            $table->integer('max_products')->nullable();
            $table->integer('max_services')->nullable();
            $table->boolean('priority_support')->default(false);
            $table->boolean('featured_listings')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
