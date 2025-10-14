<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change the enum to include more transaction types
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('payment', 'refund', 'role_purchase', 'subscription', 'commission', 'withdrawal', 'deposit', 'transfer') DEFAULT 'payment'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('payment', 'refund') DEFAULT 'payment'");
    }
};
