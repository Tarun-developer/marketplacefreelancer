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
         Schema::create('license_activations', function (Blueprint $table) {
             $table->id();
             $table->foreignId('license_id')->constrained('licenses')->onDelete('cascade');
             $table->string('domain')->nullable();
             $table->string('ip_address');
             $table->timestamp('activated_at');
             $table->enum('status', ['active', 'revoked'])->default('active');
             $table->timestamps();

             $table->index(['license_id', 'status']);
             $table->index('domain');
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_activations');
    }
};
