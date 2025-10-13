<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spm_project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('spm_projects')->onDelete('cascade');
            $table->foreignId('task_id')->nullable()->constrained('spm_tasks')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->enum('category', ['deliverable', 'asset', 'revision', 'other'])->default('other');
            $table->text('description')->nullable();

            $table->integer('version')->default(1);
            $table->foreignId('replaces_file_id')->nullable()->constrained('spm_project_files')->onDelete('set null');

            $table->timestamps();

            $table->index('project_id');
            $table->index('task_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spm_project_files');
    }
};
