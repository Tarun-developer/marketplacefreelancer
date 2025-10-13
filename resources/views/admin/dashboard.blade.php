@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="container-fluid">
    <!-- Stats Grid -->
    <div class="row mb-4">
        <!-- Total Users -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small text-muted mb-1">Total Users</p>
                        <h3 class="mb-1">{{ $stats['total_users'] }}</h3>
                        <small class="text-success">+{{ $stats['new_users_this_month'] }} this month</small>
                    </div>
                    <div class="bg-primary rounded-circle p-3">
                        <svg class="text-white" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small text-muted mb-1">Total Revenue</p>
                        <h3 class="mb-1">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        <small class="text-success">${{ number_format($stats['revenue_this_month'], 2) }} this month</small>
                    </div>
                    <div class="bg-success rounded-circle p-3">
                        <svg class="text-white" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Orders -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small text-muted mb-1">Active Orders</p>
                        <h3 class="mb-1">{{ $stats['active_orders'] }}</h3>
                        <small class="text-primary">{{ $stats['completed_orders'] }} completed</small>
                    </div>
                    <div class="bg-info rounded-circle p-3">
                        <svg class="text-white" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Disputes -->
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <p class="small text-muted mb-1">Pending Disputes</p>
                        <h3 class="mb-1">{{ $stats['pending_disputes'] }}</h3>
                        <small class="text-danger">{{ $stats['resolved_disputes'] }} resolved</small>
                    </div>
                    <div class="bg-danger rounded-circle p-3">
                        <svg class="text-white" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted mb-1">Total Products</p>
                    <h4 class="mb-1">{{ $stats['total_products'] }}</h4>
                    <small class="text-muted">{{ $stats['pending_products'] }} pending approval</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted mb-1">Active Services</p>
                    <h4 class="mb-1">{{ $stats['active_services'] }}</h4>
                    <small class="text-muted">{{ $stats['total_services'] }} total</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted mb-1">Open Jobs</p>
                    <h4 class="mb-1">{{ $stats['open_jobs'] }}</h4>
                    <small class="text-muted">{{ $stats['total_bids'] }} total bids</small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <p class="small text-muted mb-1">Support Tickets</p>
                    <h4 class="mb-1">{{ $stats['open_tickets'] }}</h4>
                    <small class="text-muted">{{ $stats['total_tickets'] }} total</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Recent Orders -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    @forelse($recent_orders as $order)
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2">
                            <div>
                                <p class="mb-1 fw-bold">Order #{{ $order->id }}</p>
                                <small class="text-muted">{{ $order->buyer->name }} - ${{ number_format($order->amount, 2) }}</small><br>
                                <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge @if($order->status === 'completed') bg-success @elseif($order->status === 'pending') bg-warning @else bg-info @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">No recent orders</p>
                    @endforelse
                    <div class="mt-3">
                        <a href="{{ route('admin.orders.index') }}" class="text-primary text-decoration-none fw-medium">
                            View All Orders →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    @forelse($recent_users as $user)
                        <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="mb-1 fw-bold">{{ $user->name }}</p>
                                    <small class="text-muted">{{ $user->email }}</small><br>
                                    <small class="text-muted">Joined {{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary">{{ ucfirst($user->getRoleNames()->first() ?? 'User') }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3">No recent users</p>
                    @endforelse
                    <div class="mt-3">
                        <a href="{{ route('users.index') }}" class="text-primary text-decoration-none fw-medium">
                            View All Users →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Activity -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('users.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add User
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('products.create') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Product
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-info w-100 d-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View Orders
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary w-100 d-flex align-items-center justify-content-center">
                                <svg class="me-2" width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">System Status</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Database <span class="badge bg-success">Connected</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Cache <span class="badge bg-success">Active</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Queue <span class="badge bg-success">Running</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Storage <span class="text-muted">{{ $stats['storage_used'] }} / 100 GB</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Last Backup <span class="text-muted">2 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
