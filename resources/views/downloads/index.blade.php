@extends('layouts.app')

@section('title', 'My Downloads')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Downloads</h2>

            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($order->orderable->thumbnail)
                                    <img src="{{ asset('storage/' . $order->orderable->thumbnail) }}" class="card-img-top" alt="{{ $order->orderable->name }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="bi bi-file-earmark-zip text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $order->orderable->name }}</h5>
                                    <p class="card-text text-muted">{{ $order->orderable->category->name }}</p>
                                    <p class="card-text">
                                        <strong>License:</strong> {{ ucfirst($order->metadata['license_type'] ?? 'Standard') }}<br>
                                        <strong>Purchased:</strong> {{ $order->created_at->format('M d, Y') }}<br>
                                        <strong>Amount:</strong> ${{ number_format($order->amount, 2) }}
                                    </p>
                                    <a href="{{ route('downloads.download', $order) }}" class="btn btn-primary">
                                        <i class="bi bi-download me-2"></i>Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-download text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3">No Downloads Yet</h4>
                    <p class="text-muted">You haven't purchased any products yet. Browse our marketplace to find great products!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection