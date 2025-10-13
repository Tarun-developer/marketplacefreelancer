<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpmProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_number',
        'client_id',
        'freelancer_id',
        'job_id',
        'order_id',
        'title',
        'description',
        'budget',
        'paid_amount',
        'status',
        'start_date',
        'deadline',
        'completed_at',
        'progress_percentage',
        'client_approved',
        'freelancer_approved',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'start_date' => 'date',
        'deadline' => 'date',
        'completed_at' => 'datetime',
        'client_approved' => 'boolean',
        'freelancer_approved' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(SpmTask::class, 'project_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(SpmMilestone::class, 'project_id');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(SpmTimesheet::class, 'project_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SpmProjectFile::class, 'project_id');
    }

    public function extraWorkRequests(): HasMany
    {
        return $this->hasMany(SpmExtraWorkRequest::class, 'project_id');
    }
}