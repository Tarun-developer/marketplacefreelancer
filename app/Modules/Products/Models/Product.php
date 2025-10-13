<?php

namespace App\Modules\Products\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'name',
        'slug',
        'short_description',
        'description',
        'product_type',
        'tags',
        'framework_technology',
        'demo_url',
        'documentation_url',
        'price',
        'currency',
        'license_type',
        'file_path',
        'preview_images',
        'standard_price',
        'professional_price',
        'extended_price',
        'discount_percentage',
        'is_flash_sale',
        'is_free',
        'version',
        'release_date',
        'changelog',
        'has_feature_updates',
        'auto_update_url',
        'has_support',
        'support_duration',
        'support_link',
        'has_refund_guarantee',
        'refund_days',
        'refund_terms',
        'is_featured',
        'visibility',
        'publish_date',
        'author_commission',
        'team_members',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'og_image',
        'sales_count',
        'download_count',
        'status',
        'is_approved',
    ];

    protected $casts = [
        'tags' => 'array',
        'team_members' => 'array',
        'seo_keywords' => 'array',
        'preview_images' => 'array',
        'is_flash_sale' => 'boolean',
        'is_free' => 'boolean',
        'has_feature_updates' => 'boolean',
        'has_support' => 'boolean',
        'has_refund_guarantee' => 'boolean',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'release_date' => 'date',
        'publish_date' => 'date',
        'price' => 'decimal:2',
        'standard_price' => 'decimal:2',
        'professional_price' => 'decimal:2',
        'extended_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'author_commission' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function versions()
    {
        return $this->hasMany(ProductVersion::class);
    }

    public function currentVersion()
    {
        return $this->hasOne(ProductVersion::class)->latestOfMany();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);

        $this->addMediaCollection('screenshots')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);

        $this->addMediaCollection('main_file')
            ->singleFile()
            ->acceptsMimeTypes(['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed']);

        $this->addMediaCollection('preview_file')
            ->singleFile()
            ->acceptsMimeTypes(['application/zip', 'video/mp4', 'video/webm']);

        $this->addMediaCollection('documentation')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

        $this->addMediaCollection('og_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->sharpen(10);

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(1200)
            ->sharpen(10);
    }
}
