<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spm_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('spm_projects')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained('spm_tasks')->onDelete('set null');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->text('description');
            $table->integer('hours');
            $table->integer('minutes')->default(0);
            $table->date('work_date');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('rejection_reason')->nullable();

            $table->boolean('is_billable')->default(true);
            $table->decimal('rate_per_hour', 10, 2)->nullable();

            $table->timestamps();

            $table->index(['project_id', 'status']);
            $table->index(['user_id', 'work_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spm_timesheets');
    }
};
