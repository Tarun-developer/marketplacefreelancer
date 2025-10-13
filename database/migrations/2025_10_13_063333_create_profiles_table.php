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
         Schema::create('profiles', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
             $table->text('bio')->nullable();
             $table->json('skills')->nullable();
             $table->string('location')->nullable();
             $table->string('portfolio_url')->nullable();
             $table->string('avatar')->nullable();
             $table->string('badge')->nullable();
             $table->boolean('is_verified')->default(false);
             $table->enum('kyc_status', ['pending', 'approved', 'rejected'])->default('pending');
             $table->json('kyc_documents')->nullable();
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
