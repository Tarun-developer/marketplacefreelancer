<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpmTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'milestone_id',
        'assigned_to',
        'created_by',
        'title',
        'description',
        'priority',
        'status',
        'estimated_hours',
        'actual_hours',
        'due_date',
        'completed_at',
        'order',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SpmProject::class, 'project_id');
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(SpmMilestone::class, 'milestone_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(SpmTaskComment::class, 'task_id');
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(SpmTimesheet::class, 'task_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SpmProjectFile::class, 'task_id');
    }
}