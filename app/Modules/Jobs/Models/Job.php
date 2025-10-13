<?php

namespace App\Modules\Jobs\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Job extends Model
{
    use HasFactory;

    protected $table = 'marketplace_jobs';

    protected $fillable = [
        'client_id',
        'title',
        'slug',
        'description',
        'category',
        'budget_min',
        'budget_max',
        'currency',
        'duration',
        'skills_required',
        'status',
        'job_type',
        'product_id',
        'order_id',
        'is_subscription_based',
        'priority',
        'expires_at',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'expires_at' => 'datetime',
        'is_subscription_based' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'job_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Products\Models\Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Orders\Models\Order::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(JobMessage::class);
    }

    // Check if this is a support job for a purchased product
    public function isSupportJob(): bool
    {
        return $this->job_type === 'support' && $this->product_id !== null;
    }

    // Check if client has active subscription for this product
    public function hasActiveSubscription(): bool
    {
        return $this->is_subscription_based && $this->order_id !== null;
    }
}
