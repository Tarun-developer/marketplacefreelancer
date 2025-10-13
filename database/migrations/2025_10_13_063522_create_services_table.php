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
         Schema::create('services', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->string('title');
             $table->string('slug')->unique();
             $table->text('description');
             $table->string('category');
             $table->decimal('price', 10, 2);
             $table->string('currency', 3)->default('USD');
             $table->integer('delivery_time');
             $table->integer('revisions')->default(1);
             $table->json('images')->nullable();
             $table->boolean('is_active')->default(true);
             $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
