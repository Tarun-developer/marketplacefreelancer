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
         Schema::create('license_logs', function (Blueprint $table) {
             $table->id();
             $table->foreignId('license_id')->constrained('licenses')->onDelete('cascade');
             $table->string('action');
             $table->text('message')->nullable();
             $table->timestamp('timestamp');
             $table->json('metadata')->nullable();
             $table->timestamps();

             $table->index(['license_id', 'timestamp']);
             $table->index('action');
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_logs');
    }
};
