@extends('layouts.client')

@section('title', 'Order Details')

@section('page-title', 'Order #' . $order->id)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="bi bi-arrow-left me-1"></i>Back to Orders
            </a>
            <h2 class="mb-2 fw-bold">Order #{{ $order->id }}</h2>
            <div class="d-flex align-items-center gap-3">
                @php
                    $statusColors = [
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $statusColor }} px-3 py-2">
                    {{ ucfirst($order->status) }}
                </span>
                <span class="text-muted">
                    <i class="bi bi-calendar3 me-1"></i>{{ $order->created_at->format('M d, Y h:i A') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Order Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Order ID</div>
                            <div class="fw-bold">#{{ $order->id }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Order Date</div>
                            <div class="fw-bold">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Seller</div>
                            <div class="fw-bold">{{ $order->seller->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small mb-1">Order Type</div>
                            <div class="fw-bold">{{ $order->orderable_type ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Payment Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-cash-stack me-2 text-success"></i>Payment Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <strong>${{ number_format($order->amount, 2) }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total</span>
                        <h4 class="text-success mb-0">${{ number_format($order->amount, 2) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>Actions
                    </h6>
                    <div class="d-grid gap-2">
                        @if($order->status === 'completed')
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-download me-1"></i>Download Invoice
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-star me-1"></i>Leave Review
                            </button>
                        @endif
                        <button class="btn btn-outline-info">
                            <i class="bi bi-chat-dots me-1"></i>Contact Seller
                        </button>
                        @if($order->status === 'pending')
                            <button class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>Cancel Order
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
