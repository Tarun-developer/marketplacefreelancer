<?php

namespace App\Modules\Services\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

     protected $fillable = [
         'user_id',
         'title',
         'slug',
         'description',
         'category_id',
         'price',
         'currency',
         'delivery_time',
         'revisions',
         'images',
         'is_active',
         'status',
     ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
    ];

     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }

     public function category(): BelongsTo
     {
         return $this->belongsTo(\App\Modules\Products\Models\Category::class);
     }

     public function tags()
     {
         return $this->belongsToMany(\App\Modules\Products\Models\Tag::class, 'service_tags');
     }

     public function offers(): HasMany
     {
         return $this->hasMany(Offer::class);
     }
}
