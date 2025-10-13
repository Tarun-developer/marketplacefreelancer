@extends('layouts.admin')

@section('title', 'Order Details')

@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Order #{{ $order->id }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Buyer:</strong></div>
                    <div class="col-sm-9">{{ $order->buyer->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Seller:</strong></div>
                    <div class="col-sm-9">{{ $order->seller->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Amount:</strong></div>
                    <div class="col-sm-9">${{ number_format($order->amount, 2) }} {{ $order->currency }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge @if($order->status === 'pending') bg-warning @elseif($order->status === 'processing') bg-info @elseif($order->status === 'completed') bg-success @else bg-danger @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Payment Status:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge @if($order->payment_status === 'paid') bg-success @elseif($order->payment_status === 'pending') bg-warning @else bg-danger @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                @if($order->delivered_at)
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Delivered At:</strong></div>
                    <div class="col-sm-9">{{ $order->delivered_at->format('Y-m-d H:i:s') }}</div>
                </div>
                @endif
                @if($order->completed_at)
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Completed At:</strong></div>
                    <div class="col-sm-9">{{ $order->completed_at->format('Y-m-d H:i:s') }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6>Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">Edit Order</a>
                <form action="{{ route('admin.orders.refund', $order) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to refund this order?')">Refund</button>
                </form>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection