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
         Schema::create('marketplace_jobs', function (Blueprint $table) {
             $table->id();
             $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
             $table->string('title');
             $table->string('slug')->unique();
             $table->text('description');
             $table->string('category');
             $table->decimal('budget_min', 10, 2);
             $table->decimal('budget_max', 10, 2);
             $table->string('currency', 3)->default('USD');
             $table->integer('duration');
             $table->json('skills_required')->nullable();
             $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
             $table->timestamp('expires_at');
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::dropIfExists('marketplace_jobs');
     }
};
