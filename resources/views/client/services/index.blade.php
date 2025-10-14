@extends('layouts.client')

@section('title', 'Browse Services')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Browse Services</h1>
            </div>

            <div class="row">
                @forelse($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($service->description, 100) }}</p>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-primary">{{ $service->category->name ?? 'Uncategorized' }}</span>
                                    <strong class="text-success">${{ number_format($service->price, 2) }} {{ $service->currency }}</strong>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">By {{ $service->user->name }}</small>
                                    <small class="text-muted">{{ $service->delivery_time }} days</small>
                                </div>

                                @if($service->tags->count() > 0)
                                    <div class="mb-3">
                                        @foreach($service->tags->take(3) as $tag)
                                            <span class="badge bg-outline-secondary me-1">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <a href="{{ route('client.services.show', $service) }}" class="btn btn-outline-primary w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-search display-1 text-muted"></i>
                            <p class="text-muted mt-3">No services available at the moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($services->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection