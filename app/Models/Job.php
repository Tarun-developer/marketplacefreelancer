<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
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
         'priority',
     ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'skills_required' => 'array',
        'expires_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}