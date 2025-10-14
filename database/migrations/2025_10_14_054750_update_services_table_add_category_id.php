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
         Schema::table('services', function (Blueprint $table) {
             $table->foreignId('category_id')->nullable()->after('description')->constrained('categories')->onDelete('set null');
             $table->dropColumn('category');
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('services', function (Blueprint $table) {
             $table->string('category')->after('description');
             $table->dropForeign(['category_id']);
             $table->dropColumn('category_id');
         });
     }
};
