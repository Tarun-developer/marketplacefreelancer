<?php

/**
 * Settings Configuration
 *
 * This config file provides default values for application settings.
 * For dynamic settings, use the Setting model: Setting::get('key', 'default')
 *
 * Note: Config files are loaded early in the bootstrap process,
 * so we cannot use Facades or database queries here.
 */

return [
    // Role costs - can be overridden by database settings
    'client_role_cost' => env('CLIENT_ROLE_COST', 0),
    'freelancer_role_cost' => env('FREELANCER_ROLE_COST', 10),
    'vendor_role_cost' => env('VENDOR_ROLE_COST', 15),

    // Role approval settings
    'require_approval_for_roles' => env('REQUIRE_APPROVAL_FOR_ROLES', false),
    'allow_free_roles' => env('ALLOW_FREE_ROLES', true),

    // Marketplace settings
    'marketplace_commission_rate' => env('MARKETPLACE_COMMISSION_RATE', 10),
    'enable_kyc' => env('MARKETPLACE_ENABLE_KYC', true),
    'enable_2fa' => env('MARKETPLACE_ENABLE_2FA', false),

    // Default settings groups
    'groups' => [
        'general' => 'General Settings',
        'security' => 'Security Settings',
        'notifications' => 'Notification Settings',
        'maintenance' => 'Maintenance Settings',
        'roles' => 'Role Settings',
        'integrations' => 'Integration Settings',
    ],
];