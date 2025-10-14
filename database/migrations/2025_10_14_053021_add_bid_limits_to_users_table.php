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
         Schema::table('users', function (Blueprint $table) {
             $table->integer('bids_used_this_month')->default(0);
             $table->date('bids_reset_date')->nullable();
             $table->integer('extra_bids')->default(0); // For purchased extra bids
         });
     }

    /**
     * Reverse the migrations.
     */
     public function down(): void
     {
         Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['bids_used_this_month', 'bids_reset_date', 'extra_bids']);
         });
     }
};
