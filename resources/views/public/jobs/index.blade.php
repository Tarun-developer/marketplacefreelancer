@extends('layouts.guest')

@section('title', 'Find Work - Freelance Jobs')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Find Your Next Project</h1>
            <p class="lead text-muted">Browse thousands of freelance jobs and start earning today</p>
        </div>
    </div>

    <div class="row">
        @forelse($jobs as $job)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ Str::limit($job->title, 50) }}</h5>
                            <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>

                        <p class="card-text text-muted mb-3">{{ Str::limit($job->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary fw-semibold">
                                ${{ number_format($job->budget_min, 0) }} - ${{ number_format($job->budget_max, 0) }}
                            </span>
                            <small class="text-muted">{{ $job->duration }} days</small>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">By {{ $job->client->name ?? 'Client' }}</small>
                            <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
                        </div>

                        @if($job->skills_required)
                            <div class="mb-3">
                                @foreach(array_slice($job->skills_required, 0, 3) as $skill)
                                    <span class="badge bg-outline-primary me-1">{{ $skill }}</span>
                                @endforeach
                                @if(count($job->skills_required) > 3)
                                    <span class="badge bg-outline-secondary">+{{ count($job->skills_required) - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary w-100">
                            <i class="bi bi-eye me-2"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h3 class="text-muted">No jobs available</h3>
                <p class="text-muted">Check back later for new opportunities</p>
            </div>
        @endforelse
    </div>

    @if($jobs->hasPages())
        <div class="d-flex justify-content-center">
            {{ $jobs->links() }}
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