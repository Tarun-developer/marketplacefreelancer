@extends('layouts.admin')

@section('title', 'Settings Management')
@section('page-title', 'Settings Management')

@section('content')
<div class="container-fluid">
    <!-- Settings Tabs -->
    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                <i class="bi bi-gear me-2"></i>General
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">
                <i class="bi bi-shield-check me-2"></i>Security
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
                <i class="bi bi-bell me-2"></i>Notifications
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab" aria-controls="maintenance" aria-selected="false">
                <i class="bi bi-tools me-2"></i>Maintenance
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles" type="button" role="tab" aria-controls="roles" aria-selected="false">
                <i class="bi bi-people me-2"></i>Roles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations" type="button" role="tab" aria-controls="integrations" aria-selected="false">
                <i class="bi bi-plug me-2"></i>Integrations
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="spm-tab" data-bs-toggle="tab" data-bs-target="#spm" type="button" role="tab" aria-controls="spm" aria-selected="false">
                <i class="bi bi-kanban me-2"></i>SPM Settings
            </button>
        </li>
    </ul>

    <div class="tab-content" id="settingsTabsContent">
        <!-- General Settings -->
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">General Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="site_name" class="form-label">Site Name</label>
                                <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', config('app.name')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="site_description" class="form-label">Site Description</label>
                                <textarea name="site_description" id="site_description" class="form-control" rows="3">{{ old('site_description', 'Your marketplace description') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="site_email" class="form-label">Site Email</label>
                                <input type="email" name="site_email" id="site_email" class="form-control" value="{{ old('site_email', config('mail.from.address')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label">Contact Phone</label>
                                <input type="tel" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', '+1-234-567-8900') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="default_currency" class="form-label">Default Currency</label>
                                <select name="default_currency" id="default_currency" class="form-select">
                                    <option value="USD" {{ config('app.currency') === 'USD' ? 'selected' : '' }}>USD ($)</option>
                                    <option value="EUR" {{ config('app.currency') === 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                                    <option value="GBP" {{ config('app.currency') === 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                                    <option value="CAD" {{ config('app.currency') === 'CAD' ? 'selected' : '' }}>CAD (C$)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="commission_rate" class="form-label">Default Commission Rate (%)</label>
                                <input type="number" name="commission_rate" id="commission_rate" class="form-control" step="0.01" min="0" max="100" value="{{ old('commission_rate', 15.00) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="timezone" class="form-label">Timezone</label>
                                <select name="timezone" id="timezone" class="form-select">
                                    <option value="UTC" {{ config('app.timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    <option value="America/New_York" {{ config('app.timezone') === 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                    <option value="America/Chicago" {{ config('app.timezone') === 'America/Chicago' ? 'selected' : '' }}>Central Time</option>
                                    <option value="America/Denver" {{ config('app.timezone') === 'America/Denver' ? 'selected' : '' }}>Mountain Time</option>
                                    <option value="America/Los_Angeles" {{ config('app.timezone') === 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="items_per_page" class="form-label">Items Per Page</label>
                                <input type="number" name="items_per_page" id="items_per_page" class="form-control" min="5" max="100" value="{{ old('items_per_page', 15) }}" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update General Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.security') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password_min_length" class="form-label">Minimum Password Length</label>
                                <input type="number" name="password_min_length" id="password_min_length" class="form-control" min="6" max="20" value="{{ old('password_min_length', 8) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="session_lifetime" class="form-label">Session Lifetime (minutes)</label>
                                <input type="number" name="session_lifetime" id="session_lifetime" class="form-control" min="15" max="1440" value="{{ old('session_lifetime', 120) }}" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="require_email_verification" id="require_email_verification" {{ old('require_email_verification', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_email_verification">
                                        Require Email Verification for Registration
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enable_two_factor" id="enable_two_factor" {{ old('enable_two_factor', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_two_factor">
                                        Enable Two-Factor Authentication
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enable_captcha" id="enable_captcha" {{ old('enable_captcha', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_captcha">
                                        Enable CAPTCHA on Registration/Login
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="enable_rate_limiting" id="enable_rate_limiting" {{ old('enable_rate_limiting', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="enable_rate_limiting">
                                        Enable Rate Limiting
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Security Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notifications Settings -->
        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Notification Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.notifications') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications" {{ old('email_notifications', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="email_notifications">
                                        Enable Email Notifications
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sms_notifications" id="sms_notifications" {{ old('sms_notifications', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sms_notifications">
                                        Enable SMS Notifications
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="push_notifications" id="push_notifications" {{ old('push_notifications', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="push_notifications">
                                        Enable Push Notifications
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="notification_email" class="form-label">Notification Email</label>
                                <input type="email" name="notification_email" id="notification_email" class="form-control" value="{{ old('notification_email', config('mail.from.address')) }}">
                            </div>
                            <div class="col-12">
                                <h6>Notification Events</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="notify_new_user" id="notify_new_user" {{ old('notify_new_user', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="notify_new_user">
                                                New User Registration
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="notify_new_order" id="notify_new_order" {{ old('notify_new_order', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="notify_new_order">
                                                New Order Placed
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="notify_payment" id="notify_payment" {{ old('notify_payment', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="notify_payment">
                                                Payment Received
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Notification Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Maintenance Settings -->
        <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="maintenance-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Maintenance Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.maintenance') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode" {{ old('maintenance_mode', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="maintenance_mode">
                                        Enable Maintenance Mode
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="maintenance_message" class="form-label">Maintenance Message</label>
                                <textarea name="maintenance_message" id="maintenance_message" class="form-control" rows="3">{{ old('maintenance_message', 'Site is under maintenance. Please check back later.') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="allowed_ips" class="form-label">Allowed IPs (comma-separated)</label>
                                <textarea name="allowed_ips" id="allowed_ips" class="form-control" rows="3" placeholder="127.0.0.1,192.168.1.1">{{ old('allowed_ips', '127.0.0.1') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="cache_clear" class="form-label">Cache Management</label>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-warning" onclick="clearCache()">Clear Application Cache</button>
                                    <button type="button" class="btn btn-info" onclick="clearViewCache()">Clear View Cache</button>
                                    <button type="button" class="btn btn-secondary" onclick="clearRouteCache()">Clear Route Cache</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Maintenance Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Role Management Settings -->
        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Role Management Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.roles') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="client_role_cost" class="form-label">Client Role Cost ($)</label>
                                <input type="number" name="client_role_cost" id="client_role_cost" class="form-control" step="0.01" min="0" value="{{ old('client_role_cost', 0.00) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="freelancer_role_cost" class="form-label">Freelancer Role Cost ($)</label>
                                <input type="number" name="freelancer_role_cost" id="freelancer_role_cost" class="form-control" step="0.01" min="0" value="{{ old('freelancer_role_cost', 0.00) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="vendor_role_cost" class="form-label">Vendor Role Cost ($)</label>
                                <input type="number" name="vendor_role_cost" id="vendor_role_cost" class="form-control" step="0.01" min="0" value="{{ old('vendor_role_cost', 0.00) }}">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="require_approval_for_roles" id="require_approval_for_roles" {{ old('require_approval_for_roles', false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="require_approval_for_roles">
                                        Require Admin Approval for Role Requests
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="allow_free_roles" id="allow_free_roles" {{ old('allow_free_roles', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="allow_free_roles">
                                        Allow Free Role Assignment
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Role Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Integrations Settings -->
        <div class="tab-pane fade" id="integrations" role="tabpanel" aria-labelledby="integrations-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Third-Party Integrations</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.integrations') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="stripe_public_key" class="form-label">Stripe Public Key</label>
                                <input type="text" name="stripe_public_key" id="stripe_public_key" class="form-control" value="{{ old('stripe_public_key', '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="stripe_secret_key" class="form-label">Stripe Secret Key</label>
                                <input type="password" name="stripe_secret_key" id="stripe_secret_key" class="form-control" value="{{ old('stripe_secret_key', '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="paypal_client_id" class="form-label">PayPal Client ID</label>
                                <input type="text" name="paypal_client_id" id="paypal_client_id" class="form-control" value="{{ old('paypal_client_id', '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="paypal_secret" class="form-label">PayPal Secret</label>
                                <input type="password" name="paypal_secret" id="paypal_secret" class="form-control" value="{{ old('paypal_secret', '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="google_analytics_id" class="form-label">Google Analytics ID</label>
                                <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control" value="{{ old('google_analytics_id', '') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="facebook_pixel_id" class="form-label">Facebook Pixel ID</label>
                                <input type="text" name="facebook_pixel_id" id="facebook_pixel_id" class="form-control" value="{{ old('facebook_pixel_id', '') }}">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update Integration Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SPM Settings -->
        <div class="tab-pane fade" id="spm" role="tabpanel" aria-labelledby="spm-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Smart Project Manager (SPM) Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.spm') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>About SPM:</strong> Smart Project Manager is a premium addon feature that allows users to manage their freelance projects with advanced tools like task management, time tracking, milestones, and more.
                                </div>
                            </div>

                            <div class="col-12">
                                <h6>Subscription Plans Management</h6>
                                <p class="text-muted small">Manage SPM subscription plans and pricing from the <a href="{{ route('admin.subscriptions.index') }}" class="text-decoration-none">Subscriptions Management</a> page.</p>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_enabled" id="spm_enabled" {{ old('spm_enabled', \App\Models\Setting::get('spm_enabled', true)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_enabled">
                                        Enable SPM Feature for Users
                                    </label>
                                </div>
                                <small class="text-muted">Allow users to purchase and access SPM features</small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_free_trial" id="spm_free_trial" {{ old('spm_free_trial', \App\Models\Setting::get('spm_free_trial', true)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_free_trial">
                                        Enable Free Trial
                                    </label>
                                </div>
                                <small class="text-muted">Allow users to try SPM Free plan</small>
                            </div>

                            <div class="col-md-6">
                                <label for="spm_trial_days" class="form-label">Free Trial Days</label>
                                <input type="number" name="spm_trial_days" id="spm_trial_days" class="form-control" min="0" max="90" value="{{ old('spm_trial_days', \App\Models\Setting::get('spm_trial_days', 14)) }}">
                                <small class="text-muted">Number of days for free trial (0 to disable)</small>
                            </div>

                            <div class="col-md-6">
                                <label for="spm_commission_rate" class="form-label">SPM Transaction Commission (%)</label>
                                <input type="number" name="spm_commission_rate" id="spm_commission_rate" class="form-control" step="0.01" min="0" max="100" value="{{ old('spm_commission_rate', \App\Models\Setting::get('spm_commission_rate', 0)) }}">
                                <small class="text-muted">Commission on payments made through SPM</small>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_require_approval" id="spm_require_approval" {{ old('spm_require_approval', \App\Models\Setting::get('spm_require_approval', false)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_require_approval">
                                        Require Admin Approval for New Subscriptions
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_auto_renew" id="spm_auto_renew" {{ old('spm_auto_renew', \App\Models\Setting::get('spm_auto_renew', true)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_auto_renew">
                                        Enable Auto-Renewal by Default
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                                <h6>Feature Limits (Default for Free Plan)</h6>
                            </div>

                            <div class="col-md-4">
                                <label for="spm_max_projects_free" class="form-label">Max Projects (Free Plan)</label>
                                <input type="number" name="spm_max_projects_free" id="spm_max_projects_free" class="form-control" min="1" value="{{ old('spm_max_projects_free', \App\Models\Setting::get('spm_max_projects_free', 1)) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="spm_max_tasks_free" class="form-label">Max Tasks per Project (Free)</label>
                                <input type="number" name="spm_max_tasks_free" id="spm_max_tasks_free" class="form-control" min="1" value="{{ old('spm_max_tasks_free', \App\Models\Setting::get('spm_max_tasks_free', 10)) }}">
                            </div>

                            <div class="col-md-4">
                                <label for="spm_storage_free" class="form-label">Storage Limit (MB - Free)</label>
                                <input type="number" name="spm_storage_free" id="spm_storage_free" class="form-control" min="1" value="{{ old('spm_storage_free', \App\Models\Setting::get('spm_storage_free', 100)) }}">
                            </div>

                            <div class="col-12">
                                <hr class="my-3">
                                <h6>Email Notifications</h6>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_notify_subscription" id="spm_notify_subscription" {{ old('spm_notify_subscription', \App\Models\Setting::get('spm_notify_subscription', true)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_notify_subscription">
                                        Notify Admin on New Subscriptions
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="spm_notify_expiry" id="spm_notify_expiry" {{ old('spm_notify_expiry', \App\Models\Setting::get('spm_notify_expiry', true)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spm_notify_expiry">
                                        Notify Users Before Expiry (7 days)
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update SPM Settings</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Are you sure you want to clear the application cache?')) {
        fetch('{{ route("admin.settings.clear-cache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(response => response.json()).then(data => {
            alert(data.message || 'Cache cleared successfully');
        }).catch(error => {
            alert('Error clearing cache');
        });
    }
}

function clearViewCache() {
    if (confirm('Are you sure you want to clear the view cache?')) {
        fetch('{{ route("admin.settings.clear-view-cache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(response => response.json()).then(data => {
            alert(data.message || 'View cache cleared successfully');
        }).catch(error => {
            alert('Error clearing view cache');
        });
    }
}

function clearRouteCache() {
    if (confirm('Are you sure you want to clear the route cache?')) {
        fetch('{{ route("admin.settings.clear-route-cache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        }).then(response => response.json()).then(data => {
            alert(data.message || 'Route cache cleared successfully');
        }).catch(error => {
            alert('Error clearing route cache');
        });
    }
}
</script>
@endsection