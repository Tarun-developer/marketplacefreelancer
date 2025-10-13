@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="container-fluid">
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                            <div class="text-xs text-success mt-1">+{{ $stats['new_users_this_month'] }} this month</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($stats['total_revenue'], 2) }}</div>
                            <div class="text-xs text-success mt-1">${{ number_format($stats['revenue_this_month'], 2) }} this month</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-dollar fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Active Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_orders'] }}</div>
                            <div class="text-xs text-info mt-1">{{ $stats['completed_orders'] }} completed</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart3 fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Disputes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_disputes'] }}</div>
                            <div class="text-xs text-success mt-1">{{ $stats['resolved_disputes'] }} resolved</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-exclamation-triangle fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Total Products</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                    <div class="text-xs text-muted mt-1">{{ $stats['pending_products'] }} pending approval</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Active Services</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_services'] }}</div>
                    <div class="text-xs text-muted mt-1">{{ $stats['total_services'] }} total</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Open Jobs</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['open_jobs'] }}</div>
                    <div class="text-xs text-muted mt-1">{{ $stats['total_bids'] }} total bids</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Support Tickets</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['open_tickets'] }}</div>
                    <div class="text-xs text-muted mt-1">{{ $stats['total_tickets'] }} total</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Users -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                </div>
                <div class="card-body">
                    @forelse($recent_orders as $order)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div>
                                <div class="font-weight-bold">Order #{{ $order->id }}</div>
                                <div class="text-muted small">{{ $order->buyer->name ?? 'Unknown' }} - ${{ number_format($order->amount, 2) }}</div>
                                <div class="text-muted small">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge
                                @if($order->status === 'completed') bg-success
                                @elseif($order->status === 'pending') bg-warning
                                @else bg-info @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No recent orders</p>
                    @endforelse
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm mt-3">View All Orders</a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                </div>
                <div class="card-body">
                    @forelse($recent_users as $user)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="ms-3">
                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                    <div class="text-muted small">Joined {{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <span class="badge bg-primary">{{ ucfirst($user->getRoleNames()->first() ?? 'User') }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">No recent users</p>
                    @endforelse
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm mt-3">View All Users</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100">
                                <i class="bi bi-person-plus me-2"></i>Add User
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle me-2"></i>Add Product
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-info w-100">
                                <i class="bi bi-eye me-2"></i>View Orders
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Database</span>
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>Connected</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Cache</span>
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>Active</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Queue</span>
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>Running</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Storage</span>
                            <span class="text-muted">{{ $stats['storage_used'] }} / 100 GB</span>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <span>Last Backup</span>
                            <span class="text-muted">2 hours ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection