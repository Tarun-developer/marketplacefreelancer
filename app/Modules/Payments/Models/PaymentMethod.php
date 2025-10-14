<?php

namespace App\Modules\Payments\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_gateway_id',
        'nickname',
        'type',
        'encrypted_data',
        'last_four',
        'brand',
        'expiry_month',
        'expiry_year',
        'is_default',
        'is_verified',
        'verification_token',
        'verified_at',
        'last_used_at',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    protected $hidden = [
        'encrypted_data',
        'verification_token',
    ];

    /**
     * Get the user that owns the payment method
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment gateway
     */
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    /**
     * Get decrypted payment data
     */
    public function getDecryptedData(): array
    {
        if (empty($this->encrypted_data)) {
            return [];
        }

        try {
            return json_decode(Crypt::decryptString($this->encrypted_data), true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Set encrypted payment data
     */
    public function setPaymentData(array $data): void
    {
        $this->encrypted_data = Crypt::encryptString(json_encode($data));
        $this->save();
    }

    /**
     * Get masked display name
     */
    public function getMaskedDisplayAttribute(): string
    {
        if ($this->nickname) {
            return $this->nickname;
        }

        $brandName = $this->brand ?? $this->type;

        if ($this->last_four) {
            return "{$brandName} ending in {$this->last_four}";
        }

        return $brandName;
    }

    /**
     * Check if card is expired
     */
    public function isExpired(): bool
    {
        if (!$this->expiry_month || !$this->expiry_year) {
            return false;
        }

        $expiryDate = \Carbon\Carbon::createFromDate($this->expiry_year, $this->expiry_month, 1)->endOfMonth();

        return $expiryDate->isPast();
    }

    /**
     * Mark as default payment method
     */
    public function markAsDefault(): void
    {
        // Unset other default methods for this user
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        $this->update(['is_default' => true]);
    }

    /**
     * Mark as verified
     */
    public function markAsVerified(): void
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verification_token' => null,
        ]);
    }

    /**
     * Record usage
     */
    public function recordUsage(): void
    {
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Scope for default payment methods
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope for verified payment methods
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for active (non-expired) payment methods
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_year')
              ->orWhere(function ($q2) {
                  $q2->where('expiry_year', '>', now()->year)
                     ->orWhere(function ($q3) {
                         $q3->where('expiry_year', now()->year)
                            ->where('expiry_month', '>=', now()->month);
                     });
              });
        });
    }
}
