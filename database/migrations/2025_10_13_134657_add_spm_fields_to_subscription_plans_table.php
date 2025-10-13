<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->string('plan_type')->default('general')->after('is_active')->comment('general, spm');
            $table->integer('spm_max_projects')->nullable()->after('plan_type');
            $table->integer('spm_max_tasks_per_project')->nullable()->after('spm_max_projects');
            $table->decimal('spm_storage_gb', 8, 2)->nullable()->after('spm_max_tasks_per_project');
            $table->boolean('spm_has_reports')->default(false)->after('spm_storage_gb');
            $table->boolean('spm_has_api')->default(false)->after('spm_has_reports');
        });
    }

    public function down(): void
    {
        Schema::table('subscription_plans', function (Blueprint $table) {
            $table->dropColumn([
                'plan_type',
                'spm_max_projects',
                'spm_max_tasks_per_project',
                'spm_storage_gb',
                'spm_has_reports',
                'spm_has_api',
            ]);
        });
    }
};
