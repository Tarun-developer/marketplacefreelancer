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
        'expires_at',
    ];

    protected $casts = [
        'skills_required' => 'array',
        'expires_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'job_id');
    }
}
