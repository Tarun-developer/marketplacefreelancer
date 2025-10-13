<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'action',
        'message',
        'timestamp',
        'metadata',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'metadata' => 'array',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }
}