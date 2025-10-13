<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'version_number',
        'changelog',
        'release_date',
        'file_path',
        'file_size',
        'file_hashes',
        'is_active',
        'download_count',
        'published_at',
    ];

    protected $casts = [
        'release_date' => 'date',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'file_hashes' => 'array',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the current active version for a product
     */
    public static function getCurrentVersion($productId)
    {
        return static::where('product_id', $productId)
            ->where('is_active', true)
            ->latest('version_number')
            ->first();
    }

    /**
     * Create a new version for a product
     */
    public static function createVersion($productId, $versionData)
    {
        // Deactivate previous versions
        static::where('product_id', $productId)->update(['is_active' => false]);

        return static::create(array_merge($versionData, [
            'product_id' => $productId,
            'is_active' => true,
            'published_at' => now(),
        ]));
    }
}