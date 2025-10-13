<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpmTimesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'task_id',
        'user_id',
        'description',
        'hours',
        'minutes',
        'work_date',
        'status',
        'approved_at',
        'approved_by',
        'rejection_reason',
        'is_billable',
        'rate_per_hour',
    ];

    protected $casts = [
        'work_date' => 'date',
        'approved_at' => 'datetime',
        'is_billable' => 'boolean',
        'rate_per_hour' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SpmProject::class, 'project_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(SpmTask::class, 'task_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}