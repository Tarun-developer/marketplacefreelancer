@extends('layouts.app')

@section('title', 'User Dashboard - Overview')

@section('content')
<div class="container-fluid py-4 px-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2 fw-bold">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-muted mb-0">Here's your complete activity overview across all your roles</p>
                </div>
                <div class="d-none d-md-block">
                    <div class="badge bg-gradient-primary px-3 py-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="bi bi-calendar-event me-2"></i>{{ now()->format('l, M d, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Role Access Cards -->
    <div class="row g-4 mb-4">
        @php
            $allRoles = [
                'client' => [
                    'icon' => 'bi-person-badge',
                    'color' => 'primary',
                    'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'label' => 'Client Dashboard',
                    'description' => 'Manage your jobs and orders',
                    'route' => 'client.dashboard',
                    'hasRole' => in_array('client', $userRoles)
                ],
                'freelancer' => [
                    'icon' => 'bi-briefcase',
                    'color' => 'success',
                    'gradient' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
                    'label' => 'Freelancer Dashboard',
                    'description' => 'View your gigs and proposals',
                    'route' => 'freelancer.dashboard',
                    'hasRole' => in_array('freelancer', $userRoles)
                ],
                'vendor' => [
                    'icon' => 'bi-shop',
                    'color' => 'info',
                    'gradient' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
                    'label' => 'Vendor Dashboard',
                    'description' => 'Manage your products and sales',
                    'route' => 'vendor.dashboard',
                    'hasRole' => in_array('vendor', $userRoles)
                ]
            ];
        @endphp

        @foreach($allRoles as $roleKey => $config)
            <div class="col-lg-4 col-md-6">
                @if($config['hasRole'])
                    <a href="{{ route($config['route']) }}" class="text-decoration-none">
                        <div class="card border-0 shadow-sm h-100 role-card" style="background: {{ $config['gradient'] }}; color: white;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                                        <i class="bi {{ $config['icon'] }} fs-2"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1 text-white">{{ $config['label'] }}</h5>
                                        <small class="text-white-50">{{ $config['description'] }}</small>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <span class="text-white-50 small">Click to access</span>
                                    <div class="btn btn-light btn-sm">
                                        View Dashboard <i class="bi bi-arrow-right ms-1"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @else
                    <div class="card border-2 border-dashed h-100" style="border-color: {{ $config['color'] }};">
                        <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center">
                            <div class="rounded-circle bg-{{$config['color']}} bg-opacity-10 p-3 mb-3">
                                <i class="bi bi-lock fs-2 text-{{ $config['color'] }}"></i>
                            </div>
                            <h5 class="mb-2">{{ $config['label'] }}</h5>
                            <p class="text-muted small mb-3">{{ $config['description'] }}</p>
                            <a href="{{ route('checkout', $roleKey) }}" class="btn btn-{{ $config['color'] }}">
                                <i class="bi bi-unlock me-1"></i>Unlock Role
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Activity Overview Title -->
    <div class="row mb-3">
        <div class="col-12">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-graph-up text-primary me-2"></i>Your Activity Overview
            </h4>
        </div>
    </div>

    <!-- Combined Statistics -->
    <div class="row g-4 mb-4">
        @if(in_array('client', $userRoles))
            <!-- Client Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Posted Jobs</p>
                                <h2 class="mb-0 fw-bold">{{ $stats['client']['posted_jobs'] ?? 0 }}</h2>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="bi bi-briefcase fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 75%;"></div>
                        </div>
                        <a href="{{ route('client.dashboard') }}" class="small text-primary text-decoration-none mt-2 d-inline-block">
                            View Details <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Total Spent</p>
                                <h2 class="mb-0 fw-bold">${{ number_format($stats['client']['total_spent'] ?? 0, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-cash-stack fs-4 text-warning"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-clock text-warning me-1"></i>{{ $stats['client']['active_orders'] ?? 0 }} active orders
                        </small>
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('freelancer', $userRoles))
            <!-- Freelancer Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Active Gigs</p>
                                <h2 class="mb-0 fw-bold">{{ $stats['freelancer']['active_gigs'] ?? 0 }}</h2>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-star fs-4 text-success"></i>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 60%;"></div>
                        </div>
                        <a href="{{ route('freelancer.dashboard') }}" class="small text-success text-decoration-none mt-2 d-inline-block">
                            View Details <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Total Earnings</p>
                                <h2 class="mb-0 fw-bold">${{ number_format($stats['freelancer']['total_earnings'] ?? 0, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-currency-dollar fs-4 text-success"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-check-circle text-success me-1"></i>{{ $stats['freelancer']['completed_jobs'] ?? 0 }} completed jobs
                        </small>
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('vendor', $userRoles))
            <!-- Vendor Stats -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Total Products</p>
                                <h2 class="mb-0 fw-bold">{{ $stats['vendor']['total_products'] ?? 0 }}</h2>
                            </div>
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-box-seam fs-4 text-info"></i>
                            </div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-info" style="width: 85%;"></div>
                        </div>
                        <a href="{{ route('vendor.dashboard') }}" class="small text-info text-decoration-none mt-2 d-inline-block">
                            View Details <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <p class="text-muted mb-1 small text-uppercase">Total Sales</p>
                                <h2 class="mb-0 fw-bold">${{ number_format($stats['vendor']['total_sales'] ?? 0, 2) }}</h2>
                            </div>
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-graph-up fs-4 text-info"></i>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-hourglass-split text-info me-1"></i>{{ $stats['vendor']['pending_orders'] ?? 0 }} pending orders
                        </small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Recent Activity Section -->
    <div class="row g-4">
        @if(in_array('client', $userRoles) && !empty($recentActivity['client_orders']))
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-person-badge text-primary me-2"></i>Recent Orders (Client)
                            </h5>
                            <a href="{{ route('client.dashboard') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['client_orders'] as $order)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-receipt text-primary"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">Order #{{ $order->id }}</h6>
                                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="fw-bold mt-1 text-primary">${{ number_format($order->amount, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('freelancer', $userRoles) && !empty($recentActivity['freelancer_jobs']))
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-briefcase text-success me-2"></i>Active Jobs (Freelancer)
                            </h5>
                            <a href="{{ route('freelancer.dashboard') }}" class="btn btn-sm btn-outline-success">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['freelancer_jobs'] as $job)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-file-earmark-text text-success"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ Str::limit($job->title ?? 'Job #' . $job->id, 40) }}</h6>
                                        <small class="text-muted"><i class="bi bi-person me-1"></i>Client: {{ $job->client->name ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">Active</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(in_array('vendor', $userRoles) && !empty($recentActivity['vendor_orders']))
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">
                                <i class="bi bi-shop text-info me-2"></i>Recent Sales (Vendor)
                            </h5>
                            <a href="{{ route('vendor.dashboard') }}" class="btn btn-sm btn-outline-info">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($recentActivity['vendor_orders'] as $order)
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-cart text-info"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">Order #{{ $order->id }}</h6>
                                        <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <div class="fw-bold mt-1 text-info">${{ number_format($order->amount, 2) }}</div>
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
                <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-plus-circle display-3 mb-3 text-white"></i>
                        <h3 class="fw-bold mb-3">Unlock More Features</h3>
                        <p class="mb-4 fs-5">You have {{ count($userRoles) }} of 3 roles. Purchase additional roles to access more features and opportunities!</p>
                        <a href="{{ route('dashboard.select-role') }}" class="btn btn-light btn-lg px-5">
                            <i class="bi bi-unlock me-2"></i>Browse Available Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.role-card {
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.role-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0,0,0,0.2) !important;
}

.stat-card {
    transition: all 0.3s ease;
    border-radius: 1rem;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card {
    border-radius: 1rem;
}

.progress {
    border-radius: 10px;
    background-color: rgba(0,0,0,0.05);
}

.progress-bar {
    border-radius: 10px;
}

.badge {
    padding: 0.4rem 0.8rem;
    font-weight: 600;
}

.border-dashed {
    border-style: dashed !important;
}
</style>
@endsection
