<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Order extends Model
{
     protected $fillable = [
         'buyer_id',
         'seller_id',
         'orderable_type',
         'orderable_id',
         'amount',
         'currency',
         'status',
         'payment_status',
         'delivered_at',
         'completed_at',
         'requirements',
     ];

    protected $casts = [
        'amount' => 'decimal:2',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderable(): MorphTo
    {
        return $this->morphTo();
    }

     public function product()
     {
         return $this->morphTo('orderable', 'orderable_type', 'orderable_id');
     }

     public function service()
     {
         return $this->belongsTo(\App\Modules\Services\Models\Service::class, 'orderable_id');
     }
}