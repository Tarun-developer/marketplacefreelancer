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
         Schema::create('reviews', function (Blueprint $table) {
             $table->id();
             $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('reviewee_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
             $table->tinyInteger('rating')->unsigned();
             $table->text('comment')->nullable();
             $table->enum('type', ['product', 'service', 'job'])->default('product');
             $table->timestamps();

             $table->unique(['reviewer_id', 'order_id']);
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
