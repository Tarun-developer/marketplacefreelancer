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
        Schema::table('kycs', function (Blueprint $table) {
            $table->enum('document_type', ['passport', 'id_card', 'driver_license'])->nullable()->change();
            $table->string('document_number')->nullable()->change();
            $table->string('document_file')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kycs', function (Blueprint $table) {
            $table->enum('document_type', ['passport', 'id_card', 'driver_license'])->nullable(false)->change();
            $table->string('document_number')->nullable(false)->change();
            $table->string('document_file')->nullable(false)->change();
        });
    }
};
