<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Users\Models\Kyc;
use App\Modules\Users\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, InteractsWithMedia, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $fillable = [
         'name',
         'email',
         'password',
         'role',
         'current_role',
         'is_active',
         'email_verified_at',
     ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function kyc()
    {
        return $this->hasOne(Kyc::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Modules\Subscriptions\Models\Subscription::class);
    }

    public function wallet()
    {
        return $this->hasOne(\App\Modules\Wallet\Models\Wallet::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(\App\Modules\Wallet\Models\WalletTransaction::class);
    }

    public function ordersAsBuyer()
    {
        return $this->hasMany(\App\Modules\Orders\Models\Order::class, 'buyer_id');
    }

    public function ordersAsSeller()
    {
        return $this->hasMany(\App\Modules\Orders\Models\Order::class, 'seller_id');
    }

    public function orders()
    {
        return $this->ordersAsBuyer()->union($this->ordersAsSeller());
    }

    public function services()
    {
        return $this->hasMany(\App\Modules\Services\Models\Service::class);
    }

    public function jobs()
    {
        return $this->hasMany(\App\Modules\Jobs\Models\Job::class, 'client_id');
    }

    public function bids()
    {
        return $this->hasMany(\App\Modules\Jobs\Models\Bid::class, 'freelancer_id');
    }

    public function products()
    {
        return $this->hasMany(\App\Modules\Products\Models\Product::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Modules\Reviews\Models\Review::class);
    }

    public function disputes()
    {
        return $this->hasMany(\App\Modules\Disputes\Models\Dispute::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(\App\Modules\Support\Models\SupportTicket::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(\App\Modules\Chat\Models\Conversation::class, 'conversation_user');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->sharpen(10);

        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->sharpen(10);
    }
}
