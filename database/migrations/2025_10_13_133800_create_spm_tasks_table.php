<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spm_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('spm_projects')->onDelete('cascade');
            $table->unsignedBigInteger('milestone_id')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['todo', 'in_progress', 'review', 'completed', 'blocked'])->default('todo');

            $table->integer('estimated_hours')->nullable();
            $table->integer('actual_hours')->default(0);
            $table->date('due_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->integer('order')->default(0);

            $table->timestamps();

            $table->index(['project_id', 'status']);
            $table->index('milestone_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spm_tasks');
    }
};
