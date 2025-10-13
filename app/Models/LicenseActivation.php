<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseActivation extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'domain',
        'ip_address',
        'activated_at',
        'status',
    ];

    protected $casts = [
        'activated_at' => 'datetime',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }

    /**
     * Revoke activation
     */
    public function revoke()
    {
        $this->update(['status' => 'revoked']);

        $this->license->logs()->create([
            'action' => 'activation_revoked',
            'message' => "Activation revoked for domain: {$this->domain}",
            'timestamp' => now(),
        ]);

        return true;
    }
}