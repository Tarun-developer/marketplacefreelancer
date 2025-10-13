@extends('layouts.client')

@section('title', 'My Orders')

@section('page-title', 'My Orders')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold">My Orders</h2>
                    <p class="text-muted mb-0">Track and manage all your purchases</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">Order ID</th>
                                        <th class="py-3">Seller</th>
                                        <th class="py-3">Item</th>
                                        <th class="py-3">Amount</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3 text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('client.orders.show', $order->id) }}" class="text-decoration-none fw-bold">
                                                    #{{ $order->id }}
                                                </a>
                                            </td>
                                            <td class="py-3">{{ $order->seller->name ?? 'N/A' }}</td>
                                            <td class="py-3">{{ $order->orderable_type ?? 'N/A' }}</td>
                                            <td class="py-3">
                                                <span class="fw-bold text-success">${{ number_format($order->amount, 2) }}</span>
                                            </td>
                                            <td class="py-3">
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
                                            <td class="py-3">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="py-3 text-end pe-4">
                                                <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                        <h4 class="mb-3">No Orders Yet</h4>
                        <p class="text-muted mb-4">You haven't made any purchases yet. Start browsing services and products!</p>
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-shop me-2"></i>Browse Marketplace
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
