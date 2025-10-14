@extends('layouts.freelancer')

@section('title', 'Service Order Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('freelancer.service-orders') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Service Orders
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">Order #{{ $order->id }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Order Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-receipt fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $order->service->title ?? 'Service' }}</h2>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>Client: {{ $order->buyer->name }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }} me-2">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Requirements
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $order->requirements }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>Service Details
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-2"><strong>Description:</strong> {{ $order->service->description }}</p>
                                    <p class="mb-2"><strong>Delivery Time:</strong> {{ $order->service->delivery_time }} days</p>
                                    @if($order->service->tags->count() > 0)
                                        <p class="mb-0"><strong>Tags:</strong> {{ $order->service->tags->pluck('name')->implode(', ') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Order Summary
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-dollar-sign me-2"></i>Amount:</span>
                                        <strong>${{ number_format($order->amount, 2) }} {{ $order->currency }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-calendar me-2"></i>Ordered:</span>
                                        <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-user me-2"></i>Client:</span>
                                        <strong>{{ $order->buyer->name }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-cogs me-2 text-primary"></i>Actions
                            </h5>
                            <div class="d-grid gap-2">
                                @if($order->status == 'pending')
                                    <button class="btn btn-success">
                                        <i class="fas fa-play me-2"></i>Start Work
                                    </button>
                                @elseif($order->status == 'in_progress')
                                    <button class="btn btn-warning">
                                        <i class="fas fa-upload me-2"></i>Submit Delivery
                                    </button>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-check me-2"></i>Completed
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection