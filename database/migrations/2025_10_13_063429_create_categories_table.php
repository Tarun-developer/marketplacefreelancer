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
         Schema::create('categories', function (Blueprint $table) {
             $table->id();
             $table->string('name');
             $table->string('slug')->unique();
             $table->text('description')->nullable();
             $table->string('icon')->nullable();
             $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('set null');
             $table->boolean('is_active')->default(true);
             $table->decimal('commission_rate', 5, 2)->default(15.00);
             $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
