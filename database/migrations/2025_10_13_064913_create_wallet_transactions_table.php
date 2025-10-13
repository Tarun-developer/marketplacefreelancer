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
         Schema::create('wallet_transactions', function (Blueprint $table) {
             $table->id();
             $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
             $table->decimal('amount', 15, 2);
             $table->string('currency', 3)->default('USD');
             $table->enum('type', ['credit', 'debit'])->default('credit');
             $table->text('description')->nullable();
             $table->unsignedBigInteger('reference_id')->nullable();
             $table->string('reference_type')->nullable();
             $table->timestamps();

             $table->index(['reference_type', 'reference_id']);
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
