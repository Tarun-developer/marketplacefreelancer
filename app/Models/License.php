<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_id',
        'license_key',
        'license_type',
        'activation_limit',
        'activations_used',
        'status',
        'purchase_code',
        'issued_at',
        'expires_at',
        'last_validation',
        'meta',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_validation' => 'datetime',
        'meta' => 'array',
        'activation_limit' => 'integer',
        'activations_used' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Products\Models\Product::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function activations(): HasMany
    {
        return $this->hasMany(LicenseActivation::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LicenseLog::class);
    }

    /**
     * Generate a unique license key
     */
    public static function generateLicenseKey($productId, $buyerId)
    {
        do {
            $unique = strtoupper(bin2hex(random_bytes(8)));
            $licenseKey = 'LIC-' . strtoupper(dechex($productId)) . '-' . $unique;
        } while (static::where('license_key', $licenseKey)->exists());

        return $licenseKey;
    }

    /**
     * Check if license is valid for activation
     */
    public function canActivate($domain = null)
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        if ($this->activations_used >= $this->activation_limit) {
            return false;
        }

        if ($domain && $this->activations()->where('domain', $domain)->where('status', 'active')->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Activate license for a domain
     */
    public function activate($domain, $ipAddress)
    {
        if (!$this->canActivate($domain)) {
            return false;
        }

        $activation = $this->activations()->create([
            'domain' => $domain,
            'ip_address' => $ipAddress,
            'activated_at' => now(),
        ]);

        $this->increment('activations_used');
        $this->touch('last_validation');

        $this->logs()->create([
            'action' => 'activated',
            'message' => "License activated for domain: {$domain}",
            'timestamp' => now(),
        ]);

        return $activation;
    }

    /**
     * Validate license
     */
    public function validate()
    {
        $this->touch('last_validation');

        $this->logs()->create([
            'action' => 'validated',
            'message' => 'License validated successfully',
            'timestamp' => now(),
        ]);

        return [
            'status' => 'valid',
            'license_type' => $this->license_type,
            'expires_at' => $this->expires_at,
        ];
    }

    /**
     * Revoke license
     */
    public function revoke($reason = null)
    {
        $this->update(['status' => 'revoked']);

        $this->logs()->create([
            'action' => 'revoked',
            'message' => $reason ?? 'License revoked by admin',
            'timestamp' => now(),
        ]);

        return true;
    }
}