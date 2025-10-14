<?php

namespace App\Modules\Payments\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'currency',
        'gateway',
        'gateway_transaction_id',
        'payment_gateway_id',
        'payment_method_id',
        'fee_amount',
        'net_amount',
        'exchange_rate',
        'original_currency',
        'original_amount',
        'crypto_address',
        'crypto_txn_hash',
        'confirmations',
        'required_confirmations',
        'status',
        'failure_code',
        'failure_message',
        'type',
        'description',
        'ip_address',
        'user_agent',
        'metadata',
        'webhook_data',
        'webhook_received_at',
        'initiated_at',
        'processed_at',
        'completed_at',
        'failed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'exchange_rate' => 'decimal:8',
        'original_amount' => 'decimal:2',
        'metadata' => 'array',
        'webhook_data' => 'array',
        'webhook_received_at' => 'datetime',
        'initiated_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Orders\Models\Order::class);
    }

    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for failed transactions
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for refunded transactions
     */
    public function scopeRefunded($query)
    {
        return $query->where('status', 'refunded');
    }

    /**
     * Scope for payment type
     */
    public function scopePayments($query)
    {
        return $query->where('type', 'payment');
    }

    /**
     * Scope for refund type
     */
    public function scopeRefunds($query)
    {
        return $query->where('type', 'refund');
    }

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update payment gateway stats
        if ($this->paymentGateway) {
            $this->paymentGateway->recordTransaction($this->amount);
        }

        // Update payment method usage
        if ($this->paymentMethod) {
            $this->paymentMethod->recordUsage();
        }
    }

    /**
     * Mark transaction as failed
     */
    public function markAsFailed(string $code = null, string $message = null): void
    {
        $this->update([
            'status' => 'failed',
            'failed_at' => now(),
            'failure_code' => $code,
            'failure_message' => $message,
        ]);
    }

    /**
     * Mark transaction as refunded
     */
    public function markAsRefunded(): void
    {
        $this->update([
            'status' => 'refunded',
            'type' => 'refund',
        ]);
    }

    /**
     * Check if transaction is cryptocurrency
     */
    public function isCrypto(): bool
    {
        return !empty($this->crypto_address) || !empty($this->crypto_txn_hash);
    }

    /**
     * Check if crypto transaction is confirmed
     */
    public function isCryptoConfirmed(): bool
    {
        if (!$this->isCrypto()) {
            return false;
        }

        return $this->confirmations >= $this->required_confirmations;
    }

    /**
     * Get total amount including fees
     */
    public function getTotalAmountAttribute(): float
    {
        return $this->amount + $this->fee_amount;
    }

    /**
     * Get display amount in original currency if converted
     */
    public function getDisplayAmount(): string
    {
        if ($this->original_currency && $this->original_amount) {
            return "{$this->original_currency} {$this->original_amount}";
        }

        return "{$this->currency} {$this->amount}";
    }
}

