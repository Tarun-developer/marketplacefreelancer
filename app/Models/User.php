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
         'has_spm_access',
         'spm_access_expires_at',
         'spm_plan',
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
            'has_spm_access' => 'boolean',
            'spm_access_expires_at' => 'datetime',
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

    /**
     * Check if user has active SPM access
     */
    public function hasSpmAccess(): bool
    {
        if (!$this->has_spm_access) {
            return false;
        }

        // If no expiry date, access is permanent (admin grant)
        if (!$this->spm_access_expires_at) {
            return true;
        }

        // Check if not expired
        return $this->spm_access_expires_at->isFuture();
    }

    /**
     * Get active SPM subscription
     */
    public function activeSpmSubscription()
    {
        return $this->subscriptions()
            ->whereHas('plan', function ($query) {
                $query->where('plan_type', 'spm');
            })
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->first();
    }

    /**
     * Get SPM plan limits
     */
    public function getSpmLimits(): array
    {
        $subscription = $this->activeSpmSubscription();

        if (!$subscription || !$subscription->plan) {
            return [
                'max_projects' => 0,
                'max_tasks_per_project' => 0,
                'storage_gb' => 0,
                'has_reports' => false,
                'has_api' => false,
            ];
        }

        return [
            'max_projects' => $subscription->plan->spm_max_projects,
            'max_tasks_per_project' => $subscription->plan->spm_max_tasks_per_project,
            'storage_gb' => $subscription->plan->spm_storage_gb,
            'has_reports' => $subscription->plan->spm_has_reports,
            'has_api' => $subscription->plan->spm_has_api,
        ];
    }

    /**
     * Grant SPM access
     */
    public function grantSpmAccess(string $plan = 'free', ?\DateTime $expiresAt = null): void
    {
        $this->update([
            'has_spm_access' => true,
            'spm_plan' => $plan,
            'spm_access_expires_at' => $expiresAt,
        ]);
    }

    /**
     * Revoke SPM access
     */
    public function revokeSpmAccess(): void
    {
        $this->update([
            'has_spm_access' => false,
            'spm_plan' => null,
            'spm_access_expires_at' => null,
        ]);
    }
}
