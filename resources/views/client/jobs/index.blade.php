@extends('layouts.client')

@section('title', 'My Jobs')

@section('page-title', 'Manage Jobs')

@section('content')
<div class="container-fluid">
    <!-- Header with Action Button -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold">My Posted Jobs</h2>
                    <p class="text-muted mb-0">Manage and track all your job postings</p>
                </div>
                <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Post New Job
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-pills" id="jobTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button">
                                <i class="bi bi-list-ul me-1"></i>All Jobs <span class="badge bg-secondary ms-1">{{ $jobs->total() }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="open-tab" data-bs-toggle="pill" data-bs-target="#open" type="button">
                                <i class="bi bi-folder2-open me-1"></i>Open
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="progress-tab" data-bs-toggle="pill" data-bs-target="#progress" type="button">
                                <i class="bi bi-hourglass-split me-1"></i>In Progress
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed" type="button">
                                <i class="bi bi-check-circle me-1"></i>Completed
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="closed-tab" data-bs-toggle="pill" data-bs-target="#closed" type="button">
                                <i class="bi bi-x-circle me-1"></i>Closed
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs List -->
    <div class="row">
        <div class="col-12">
            @if($jobs->count() > 0)
                <div class="tab-content" id="jobTabsContent">
                    <div class="tab-pane fade show active" id="all" role="tabpanel">
                        @foreach($jobs as $job)
                            <div class="card border-0 shadow-sm mb-3 job-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h5 class="mb-0">
                                                    <a href="{{ route('client.jobs.show', $job->id) }}" class="text-decoration-none text-dark">
                                                        {{ $job->title }}
                                                    </a>
                                                </h5>
                                                @php
                                                    $statusColors = [
                                                        'open' => 'success',
                                                        'in_progress' => 'warning',
                                                        'completed' => 'info',
                                                        'closed' => 'danger'
                                                    ];
                                                    $statusColor = $statusColors[$job->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $job->status)) }}</span>
                                            </div>
                                            <p class="text-muted mb-2">{{ Str::limit($job->description, 150) }}</p>

                                            <!-- Skills -->
                                            @if(!empty($job->skills_required))
                                                <div class="mb-2">
                                                    @foreach($job->skills_required as $skill)
                                                        <span class="badge bg-light text-dark me-1">{{ $skill }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Meta Info -->
                                            <div class="d-flex flex-wrap gap-3 text-muted small">
                                                <span><i class="bi bi-calendar3 me-1"></i>Posted {{ $job->created_at->diffForHumans() }}</span>
                                                <span><i class="bi bi-chat-dots me-1"></i>{{ $job->bids->count() }} Bids</span>
                                                <span><i class="bi bi-clock me-1"></i>{{ $job->duration ?? 'Not specified' }}</span>
                                                @if($job->expires_at)
                                                    <span><i class="bi bi-hourglass-end me-1"></i>Expires {{ $job->expires_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex flex-column h-100 justify-content-between">
                                                <div class="text-end mb-3">
                                                    <div class="text-muted small mb-1">Budget</div>
                                                    <h4 class="text-primary mb-0">
                                                        ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                                                    </h4>
                                                    <small class="text-muted">{{ $job->currency ?? 'USD' }}</small>
                                                </div>
                                                <div class="d-flex gap-2 justify-content-end">
                                                    <a href="{{ route('client.jobs.show', $job->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('client.jobs.edit', $job->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <form action="{{ route('client.jobs.destroy', $job->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-briefcase display-1 text-muted mb-3"></i>
                        <h4 class="mb-3">No Jobs Posted Yet</h4>
                        <p class="text-muted mb-4">Start by posting your first job and connect with talented freelancers</p>
                        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Post Your First Job
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.job-card {
    transition: all 0.3s ease;
}

.job-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

.nav-pills .nav-link {
    color: #6c757d;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.1);
    color: #0d6efd;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
@endsection
