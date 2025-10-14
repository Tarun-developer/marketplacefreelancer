<?php

namespace App\Modules\Payments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'logo',
        'supported_currencies',
        'supported_countries',
        'transaction_fee_percentage',
        'transaction_fee_fixed',
        'transaction_fee_currency',
        'min_amount',
        'max_amount',
        'processing_time_minutes',
        'webhook_url',
        'webhook_secret',
        'test_mode',
        'sandbox_config',
        'sort_order',
        'user_instructions',
        'admin_notes',
        'is_active',
        'config',
        'last_used_at',
        'total_transactions',
        'total_volume',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'test_mode' => 'boolean',
        'supported_currencies' => 'array',
        'supported_countries' => 'array',
        'transaction_fee_percentage' => 'decimal:2',
        'transaction_fee_fixed' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'total_volume' => 'decimal:2',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = [
        'config',
        'sandbox_config',
        'webhook_secret',
    ];

    /**
     * Get encrypted config
     */
    public function getConfigAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        try {
            return json_decode(Crypt::decryptString($value), true) ?? [];
        } catch (\Exception $e) {
            // Fallback for unencrypted data (backward compatibility)
            return json_decode($value, true) ?? [];
        }
    }

    /**
     * Set encrypted config
     */
    public function setConfigAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes['config'] = Crypt::encryptString($value);
    }

    /**
     * Get encrypted sandbox config
     */
    public function getSandboxConfigAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        try {
            return json_decode(Crypt::decryptString($value), true) ?? [];
        } catch (\Exception $e) {
            return json_decode($value, true) ?? [];
        }
    }

    /**
     * Set encrypted sandbox config
     */
    public function setSandboxConfigAttribute($value)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        $this->attributes['sandbox_config'] = Crypt::encryptString($value);
    }

    /**
     * Get transactions for this gateway
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get payment methods using this gateway
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Scope for active gateways
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for fiat gateways
     */
    public function scopeFiat($query)
    {
        return $query->where('type', 'fiat');
    }

    /**
     * Scope for crypto gateways
     */
    public function scopeCrypto($query)
    {
        return $query->where('type', 'crypto');
    }

    /**
     * Scope for wallet gateways
     */
    public function scopeWallet($query)
    {
        return $query->where('type', 'wallet');
    }

    /**
     * Check if gateway supports a currency
     */
    public function supportsCurrency(string $currency): bool
    {
        return in_array(strtoupper($currency), $this->supported_currencies ?? []);
    }

    /**
     * Check if gateway supports a country
     */
    public function supportsCountry(string $country): bool
    {
        if (empty($this->supported_countries)) {
            return true; // If no countries specified, support all
        }

        return in_array(strtoupper($country), $this->supported_countries);
    }

    /**
     * Calculate total fee for an amount
     */
    public function calculateFee(float $amount): float
    {
        $percentageFee = ($amount * $this->transaction_fee_percentage) / 100;
        $totalFee = $percentageFee + $this->transaction_fee_fixed;

        return round($totalFee, 2);
    }

    /**
     * Get net amount after fees
     */
    public function getNetAmount(float $amount): float
    {
        return $amount - $this->calculateFee($amount);
    }

    /**
     * Increment transaction stats
     */
    public function recordTransaction(float $amount): void
    {
        $this->increment('total_transactions');
        $this->increment('total_volume', $amount);
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Get the active config (test or live)
     */
    public function getActiveConfig(): array
    {
        return $this->test_mode ? $this->sandbox_config : $this->config;
    }
}
