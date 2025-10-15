@extends('layouts.guest')

@section('title', 'Find Freelancers - Expert Professionals')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Expert Freelancers</h1>
            <p class="lead text-muted">Connect with skilled professionals for your projects</p>
        </div>
    </div>

    <div class="row">
        @forelse($freelancers as $freelancer)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-lift">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <span class="fw-bold fs-4">{{ strtoupper(substr($freelancer->name, 0, 1)) }}</span>
                            </div>
                        </div>

                        <h5 class="card-title mb-2">{{ $freelancer->name }}</h5>
                        <p class="card-text text-muted mb-3">{{ $freelancer->profile->title ?? 'Freelancer' }}</p>

                        @if($freelancer->services->count() > 0)
                            <div class="mb-3">
                                <small class="text-muted">{{ $freelancer->services->count() }} services</small>
                            </div>
                        @endif

                        <a href="{{ route('freelancers.show', $freelancer) }}" class="btn btn-primary w-100">
                            <i class="bi bi-eye me-2"></i>View Profile
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-people display-1 text-muted mb-3"></i>
                <h3 class="text-muted">No freelancers available</h3>
                <p class="text-muted">Check back later for new freelancers</p>
            </div>
        @endforelse
    </div>

    @if($freelancers->hasPages())
        <div class="d-flex justify-content-center">
            {{ $freelancers->links() }}
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