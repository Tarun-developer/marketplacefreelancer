<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_spm_access')->default(false)->after('email_verified_at');
            $table->timestamp('spm_access_expires_at')->nullable()->after('has_spm_access');
            $table->enum('spm_plan', ['free', 'basic', 'pro', 'enterprise'])->nullable()->after('spm_access_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['has_spm_access', 'spm_access_expires_at', 'spm_plan']);
        });
    }
};
