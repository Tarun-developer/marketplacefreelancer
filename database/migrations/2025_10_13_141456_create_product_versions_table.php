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
         Schema::create('product_versions', function (Blueprint $table) {
             $table->id();
             $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
             $table->string('version_number');
             $table->text('changelog')->nullable();
             $table->date('release_date');
             $table->string('file_path')->nullable();
             $table->bigInteger('file_size')->nullable();
             $table->json('file_hashes')->nullable(); // For integrity checking
             $table->boolean('is_active')->default(true);
             $table->integer('download_count')->default(0);
             $table->timestamp('published_at')->nullable();
             $table->timestamps();

             $table->index(['product_id', 'version_number']);
             $table->index(['product_id', 'is_active']);
         });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_versions');
    }
};
