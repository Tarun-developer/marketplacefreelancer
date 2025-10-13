<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpmExtraWorkRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'requested_by',
        'title',
        'description',
        'amount',
        'estimated_hours',
        'status',
        'approved_at',
        'rejected_at',
        'rejection_reason',
        'order_id',
        'invoice_generated',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'invoice_generated' => 'boolean',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(SpmProject::class, 'project_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}