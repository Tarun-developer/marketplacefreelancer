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
        'video_preview',
        'thumbnail',
        'screenshots',
        'main_file',
        'preview_image',
        'file_type',
        'file_size',
        'price',
        'currency',
        'license_type',
        'file_path',
        'preview_images',
        'standard_price',
        'professional_price',
        'ultimate_price',
        'discount_percentage',
        'is_flash_sale',
        'is_free',
        'money_back_guarantee',
        'refund_days',
        'refund_terms',
        'version',
        'release_date',
        'changelog',
        'feature_update_available',
        'item_support_available',
        'support_duration',
        'meta_title',
        'meta_description',
        'search_keywords',
        'canonical_url',
        'compatible_with',
        'files_included',
        'requirements',
        'license_agreement',
        'terms_of_upload',
        'author_name',
        'co_authors',
        'support_email',
        'team_name',
        'project_id',
        'estimated_delivery_time',
        'views_count',
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
        'views_count',
        'status',
        'is_approved',
    ];

    protected $casts = [
        'tags' => 'array',
        'screenshots' => 'array',
        'search_keywords' => 'array',
        'files_included' => 'array',
        'co_authors' => 'array',
        'team_members' => 'array',
        'seo_keywords' => 'array',
        'preview_images' => 'array',
        'is_flash_sale' => 'boolean',
        'is_free' => 'boolean',
        'money_back_guarantee' => 'boolean',
        'feature_update_available' => 'boolean',
        'item_support_available' => 'boolean',
        'license_agreement' => 'boolean',
        'terms_of_upload' => 'boolean',
        'is_featured' => 'boolean',
        'is_approved' => 'boolean',
        'release_date' => 'date',
        'publish_date' => 'date',
        'price' => 'decimal:2',
        'standard_price' => 'decimal:2',
        'professional_price' => 'decimal:2',
        'ultimate_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'author_commission' => 'decimal:2',
        'file_size' => 'integer',
        'estimated_delivery_time' => 'integer',
        'views_count' => 'integer',
        'sales_count' => 'integer',
        'refund_days' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function project()
    {
        return $this->belongsTo(\App\Models\SpmProject::class, 'project_id');
    }

    public function licenses()
    {
        return $this->hasMany(\App\Models\License::class);
    }

     public function tags()
     {
         return $this->belongsToMany(Tag::class, 'product_tags');
     }

     public function reviews()
     {
         return $this->hasManyThrough(\App\Modules\Reviews\Models\Review::class, \App\Modules\Orders\Models\Order::class, 'orderable_id', 'order_id');
     }

    public function versions()
    {
        return $this->hasMany(ProductVersion::class)->orderBy('version_number', 'desc');
    }

    public function currentVersion()
    {
        return $this->hasOne(ProductVersion::class)->where('is_active', true)->latestOfMany('version_number');
    }

    public function activeVersions()
    {
        return $this->hasMany(ProductVersion::class)->where('is_active', true)->orderBy('version_number', 'desc');
    }

    /**
     * Get the latest version number
     */
    public function getLatestVersionNumber()
    {
        $latest = $this->versions()->first();
        return $latest ? $latest->version_number : '1.0.0';
    }

    /**
     * Create a new version
     */
    public function createNewVersion($versionData)
    {
        return ProductVersion::createVersion($this->id, $versionData);
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
