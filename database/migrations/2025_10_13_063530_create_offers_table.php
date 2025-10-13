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
         Schema::create('offers', function (Blueprint $table) {
             $table->id();
             $table->foreignId('service_id')->constrained()->onDelete('cascade');
             $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
             $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
             $table->text('description');
             $table->decimal('price', 10, 2);
             $table->string('currency', 3)->default('USD');
             $table->integer('delivery_time');
             $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
             $table->timestamp('expires_at');
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
