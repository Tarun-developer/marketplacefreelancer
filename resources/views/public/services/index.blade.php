@extends('layouts.guest')

@section('title', 'Browse Services - Freelance Marketplace')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Professional Services</h1>
            <p class="lead text-muted">Find expert freelancers for your projects</p>
        </div>
    </div>

    <div class="row">
        @forelse($services as $service)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ Str::limit($service->title, 50) }}</h5>
                            <span class="badge bg-success">{{ ucfirst($service->status) }}</span>
                        </div>

                        <p class="card-text text-muted mb-3">{{ Str::limit($service->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary fw-semibold">
                                ${{ number_format($service->price, 2) }} {{ $service->currency }}
                            </span>
                            <small class="text-muted">{{ $service->delivery_time }} days</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">By {{ $service->user->name }}</small>
                            <small class="text-muted">{{ $service->created_at->diffForHumans() }}</small>
                        </div>

                        @if($service->tags->count() > 0)
                            <div class="mb-3">
                                @foreach($service->tags->take(3) as $tag)
                                    <span class="badge bg-outline-primary me-1">{{ $tag->name }}</span>
                                @endforeach
                                @if($service->tags->count() > 3)
                                    <span class="badge bg-outline-secondary">+{{ $service->tags->count() - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('services.show', $service) }}" class="btn btn-primary w-100">
                            <i class="bi bi-eye me-2"></i>View Service
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-tools display-1 text-muted mb-3"></i>
                <h3 class="text-muted">No services available</h3>
                <p class="text-muted">Check back later for new services</p>
            </div>
        @endforelse
    </div>

    @if($services->hasPages())
        <div class="d-flex justify-content-center">
            {{ $services->links() }}
        </div>
    @endif
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>
@endsection