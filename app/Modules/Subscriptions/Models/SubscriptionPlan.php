<?php

namespace App\Modules\Subscriptions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

     protected $fillable = [
         'name',
         'description',
         'price',
         'currency',
         'billing_period',
         'features',
         'is_active',
         'max_bids',
         'max_products',
         'max_services',
         'max_projects',
         'escrow_enabled',
         'advance_payment_required',
         'verified_required',
         'priority_support',
         'featured_listings',
         'plan_type',
         'spm_max_projects',
         'spm_max_tasks_per_project',
         'spm_storage_gb',
         'spm_has_reports',
         'spm_has_api',
     ];

     protected $casts = [
         'features' => 'array',
         'is_active' => 'boolean',
         'price' => 'decimal:2',
         'max_bids' => 'integer',
         'max_products' => 'integer',
         'max_services' => 'integer',
         'max_projects' => 'integer',
         'escrow_enabled' => 'boolean',
         'advance_payment_required' => 'boolean',
         'verified_required' => 'boolean',
         'priority_support' => 'boolean',
         'featured_listings' => 'boolean',
         'spm_max_projects' => 'integer',
         'spm_max_tasks_per_project' => 'integer',
         'spm_storage_gb' => 'decimal:2',
         'spm_has_reports' => 'boolean',
         'spm_has_api' => 'boolean',
     ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
