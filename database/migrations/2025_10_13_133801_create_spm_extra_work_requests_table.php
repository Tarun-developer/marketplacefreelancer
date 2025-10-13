<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spm_extra_work_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('spm_projects')->onDelete('cascade');
            $table->foreignId('requested_by')->constrained('users')->onDelete('cascade');

            $table->string('title');
            $table->text('description');
            $table->decimal('amount', 10, 2);
            $table->integer('estimated_hours')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
            $table->boolean('invoice_generated')->default(false);

            $table->timestamps();

            $table->index(['project_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spm_extra_work_requests');
    }
};
