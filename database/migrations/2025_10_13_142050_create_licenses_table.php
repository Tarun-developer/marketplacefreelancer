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
         Schema::create('licenses', function (Blueprint $table) {
             $table->id();
             $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
             $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
             $table->string('license_key')->unique();
             $table->enum('license_type', ['standard', 'professional', 'ultimate', 'custom'])->default('standard');
             $table->integer('activation_limit')->default(1);
             $table->integer('activations_used')->default(0);
             $table->enum('status', ['active', 'expired', 'revoked', 'pending'])->default('active');
             $table->string('purchase_code')->nullable();
             $table->timestamp('issued_at');
             $table->timestamp('expires_at')->nullable();
             $table->timestamp('last_validation')->nullable();
             $table->json('meta')->nullable();
             $table->timestamps();

             $table->index(['product_id', 'status']);
             $table->index(['buyer_id', 'status']);
             $table->index('license_key');
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
