@extends('layouts.app')

@section('title', 'User Dashboard - Overview')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-muted">Here's your complete activity overview across all your roles</p>
        </div>
    </div>

    <!-- Quick Role Access Cards -->
    <div class="row g-4 mb-4">
        @php
            $allRoles = [
                'client' => [
                    'icon' => 'bi-person-badge',
                    'color' => 'primary',
                    'label' => 'Client Dashboard',
                    'description' => 'Manage your jobs and orders',
                    'route' => 'client.dashboard',
                    'hasRole' => in_array('client', $userRoles)
                ],
                'freelancer' => [
                    'icon' => 'bi-briefcase',
                    'color' => 'success',
                    'label' => 'Freelancer Dashboard',
                    'description' => 'View your gigs and proposals',
                    'route' => 'freelancer.dashboard',
                    'hasRole' => in_array('freelancer', $userRoles)
                ],
                'vendor' => [
                    'icon' => 'bi-shop',
                    'color' => 'info',
                    'label' => 'Vendor Dashboard',
                    'description' => 'Manage your products and sales',
                    'route' => 'vendor.dashboard',
                    'hasRole' => in_array('vendor', $userRoles)
                ]
            ];
        @endphp

        @foreach($allRoles as $roleKey => $config)
            <div class="col-md-4">
                @if($config['hasRole'])
                    <a href="{{ route($config['route']) }}" class="text-decoration-none">
                        <div class="card border-{{ $config['color'] }} h-100 hover-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-{{ $config['color'] }} bg-opacity-10 p-3 me-3">
                                        <i class="bi {{ $config['icon'] }} fs-3 text-{{ $config['color'] }}"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $config['label'] }}</h5>
                                        <small class="text-muted">{{ $config['description'] }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="btn btn-sm btn-outline-{{ $config['color'] }}">
                                        Go to Dashboard <i class="bi bi-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card border-{{ $config['color'] }} border-2 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-{{ $config['color'] }} bg-opacity-10 p-3 me-3">
                                    <i class="bi {{ $config['icon'] }} fs-3 text-{{ $config['color'] }}"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $config['label'] }}</h5>
                                    <small class="text-muted">{{ $config['description'] }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('checkout', $roleKey) }}" class="btn btn-sm btn-{{ $config['color'] }}">
                                    <i class="bi bi-lock me-1"></i>Unlock Role
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Combined Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <h4 class="mb-3">Your Activity Overview</h4>
        </div>

        @if(in_array('client', $userRoles))
            <!-- Client Stats -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Posted Jobs</p>
                                <h3 class="mb-0">{{ $stats['client']['posted_jobs'] ?? 0 }}</h3>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                <i class="bi bi-briefcase text-primary"></i>
                            </div>
                        </div>
                        <a href="{{ route('client.dashboard') }}" class="small text-primary text-decoration-none">
                            View Client Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Total Spent</p>
                                <h3 class="mb-0">${{ number_format($stats['client']['total_spent'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2">
                                <i class="bi bi-cash-stack text-primary"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $stats['client']['active_orders'] ?? 0 }} active orders
                        </small>
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('freelancer', $userRoles))
            <!-- Freelancer Stats -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Active Gigs</p>
                                <h3 class="mb-0">{{ $stats['freelancer']['active_gigs'] ?? 0 }}</h3>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 p-2">
                                <i class="bi bi-star text-success"></i>
                            </div>
                        </div>
                        <a href="{{ route('freelancer.dashboard') }}" class="small text-success text-decoration-none">
                            View Freelancer Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Total Earnings</p>
                                <h3 class="mb-0">${{ number_format($stats['freelancer']['total_earnings'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 p-2">
                                <i class="bi bi-currency-dollar text-success"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $stats['freelancer']['completed_jobs'] ?? 0 }} completed jobs
                        </small>
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('vendor', $userRoles))
            <!-- Vendor Stats -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Total Products</p>
                                <h3 class="mb-0">{{ $stats['vendor']['total_products'] ?? 0 }}</h3>
                            </div>
                            <div class="rounded-circle bg-info bg-opacity-10 p-2">
                                <i class="bi bi-box-seam text-info"></i>
                            </div>
                        </div>
                        <a href="{{ route('vendor.dashboard') }}" class="small text-info text-decoration-none">
                            View Vendor Dashboard <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="text-muted mb-1 small">Total Sales</p>
                                <h3 class="mb-0">${{ number_format($stats['vendor']['total_sales'] ?? 0, 2) }}</h3>
                            </div>
                            <div class="rounded-circle bg-info bg-opacity-10 p-2">
                                <i class="bi bi-graph-up text-info"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            {{ $stats['vendor']['pending_orders'] ?? 0 }} pending orders
                        </small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4">
        @if(in_array('client', $userRoles) && !empty($recentActivity['client_orders']))
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-person-badge text-primary me-2"></i>Recent Orders (Client)</h5>
                        <a href="{{ route('client.dashboard') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['client_orders'] as $order)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="small mt-1">${{ number_format($order->amount, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('freelancer', $userRoles) && !empty($recentActivity['freelancer_jobs']))
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-briefcase text-success me-2"></i>Active Jobs (Freelancer)</h5>
                        <a href="{{ route('freelancer.dashboard') }}" class="btn btn-sm btn-outline-success">View All</a>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['freelancer_jobs'] as $job)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($job->title ?? 'Job #' . $job->id, 40) }}</h6>
                                    <small class="text-muted">Client: {{ $job->client->name ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-info">Active</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('vendor', $userRoles) && !empty($recentActivity['vendor_orders']))
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-shop text-info me-2"></i>Recent Sales (Vendor)</h5>
                        <a href="{{ route('vendor.dashboard') }}" class="btn btn-sm btn-outline-info">View All</a>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['vendor_orders'] as $order)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">Order #{{ $order->id }}</h6>
                                    <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="small mt-1">${{ number_format($order->amount, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Buy New Role Section -->
    @if(count($userRoles) < 3)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-warning bg-warning bg-opacity-10">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-plus-circle display-4 text-warning mb-3"></i>
                        <h4>Unlock More Features</h4>
                        <p class="text-muted mb-3">You have {{ count($userRoles) }} of 3 roles. Purchase additional roles to access more features!</p>
                        <a href="{{ route('dashboard.select-role') }}" class="btn btn-warning">
                            <i class="bi bi-plus-circle me-2"></i>Browse Available Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection
