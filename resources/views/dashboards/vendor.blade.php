@extends('layouts.vendor')

@section('title', 'Vendor Dashboard')

@section('page-title', 'Vendor Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Products</h6>
                            <h3 class="mb-0 text-primary">{{ $stats['total_products'] }}</h3>
                        </div>
                        <div class="text-primary" style="font-size: 2rem;">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Sales</h6>
                            <h3 class="mb-0 text-success">${{ number_format($stats['total_sales'], 2) }}</h3>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending Orders</h6>
                            <h3 class="mb-0 text-warning">{{ $stats['pending_orders'] }}</h3>
                        </div>
                        <div class="text-warning" style="font-size: 2rem;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Approved Products</h6>
                            <h3 class="mb-0 text-info">{{ $stats['approved_products'] }}</h3>
                        </div>
                        <div class="text-info" style="font-size: 2rem;">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        Quick Actions
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add New Product
                        </a>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-seam me-1"></i> Manage Products
                        </a>
                        <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-cart3 me-1"></i> View Orders
                        </a>
                        <a href="{{ route('vendor.analytics') }}" class="btn btn-outline-info">
                            <i class="bi bi-graph-up me-1"></i> View Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Product Performance -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-cart-check me-2 text-primary"></i>
                            Recent Orders
                        </h5>
                        <a href="{{ route('vendor.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($recent_orders) && $recent_orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Product</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('vendor.orders.show', $order->id) }}" class="text-decoration-none fw-bold">
                                                    #{{ $order->id }}
                                                </a>
                                            </td>
                                            <td>{{ $order->buyer->name ?? 'N/A' }}</td>
                                            <td>{{ Str::limit($order->orderable->name ?? 'Product', 30) }}</td>
                                            <td class="text-success fw-bold">${{ number_format($order->amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('vendor.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">No orders yet. Add products to start selling!</p>
                            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Add Your First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Sales Overview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-bar-chart-fill text-success me-2"></i>
                        Sales Overview
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Revenue</span>
                        <span class="fw-bold text-success">${{ number_format($stats['total_sales'], 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Active Products</span>
                        <span class="fw-bold text-primary">{{ $stats['approved_products'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Pending Orders</span>
                        <span class="fw-bold text-warning">{{ $stats['pending_orders'] }}</span>
                    </div>
                    <hr>
                    <a href="{{ route('vendor.analytics') }}" class="btn btn-sm btn-success w-100">
                        <i class="bi bi-graph-up me-1"></i> View Detailed Analytics
                    </a>
                </div>
            </div>

            <!-- Product Status -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-pie-chart-fill text-info me-2"></i>
                        Product Status
                    </h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Approved</span>
                            <span class="fw-bold text-success">{{ $stats['approved_products'] }}</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            @php
                                $approvalRate = $stats['total_products'] > 0
                                    ? ($stats['approved_products'] / $stats['total_products']) * 100
                                    : 0;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $approvalRate }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Pending Review</span>
                            <span class="fw-bold text-warning">{{ $stats['total_products'] - $stats['approved_products'] }}</span>
                        </div>
                    </div>
                    <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-list-ul me-1"></i> Manage Products
                    </a>
                </div>
            </div>

            <!-- Tips for Vendors -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Tips for Success
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Add high-quality product images</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Write detailed descriptions</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Respond to customer inquiries quickly</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Keep your products updated</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Offer competitive pricing</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
