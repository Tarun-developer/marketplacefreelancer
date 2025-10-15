@extends('layouts.client')

@section('title', 'Job Details')

@section('page-title', $job->title)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <a href="{{ route('client.jobs.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                        <i class="bi bi-arrow-left me-1"></i>Back to Jobs
                    </a>
                    <h2 class="mb-2 fw-bold">{{ $job->title }}</h2>
                    <div class="d-flex align-items-center gap-3">
                        @php
                            $statusColors = [
                                'open' => 'success',
                                'in_progress' => 'warning',
                                'completed' => 'info',
                                'closed' => 'danger',
                                'draft' => 'secondary'
                            ];
                            $statusColor = $statusColors[$job->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusColor }} px-3 py-2">
                            {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                        </span>
                        <span class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>Posted {{ $job->created_at->format('M d, Y') }}
                        </span>
                        <span class="text-muted">
                            <i class="bi bi-eye me-1"></i>{{ $job->bids->count() }} Bids Received
                        </span>
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('client.jobs.edit', $job->id) }}">
                                <i class="bi bi-pencil me-2"></i>Edit Job
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-share me-2"></i>Share Job
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('client.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this job?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-trash me-2"></i>Delete Job
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Job Description -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-file-text me-2 text-primary"></i>Job Description</h5>
                </div>
                <div class="card-body">
                    <div class="job-description">
                        {!! nl2br(e($job->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Skills Required -->
            @if(!empty($job->skills_required))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-tools me-2 text-info"></i>Required Skills</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($job->skills_required as $skill)
                            <span class="badge bg-light text-dark px-3 py-2 fs-6">
                                <i class="bi bi-check-circle-fill text-success me-1"></i>{{ $skill }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Bids Received -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-chat-left-quote me-2 text-success"></i>
                            Bids Received ({{ $job->bids->count() }})
                        </h5>
                        <button class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-filter me-1"></i>Filter Bids
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($job->bids->count() > 0)
                        @foreach($job->bids as $bid)
                            <div class="bid-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <span class="fw-bold">{{ substr($bid->freelancer->name ?? 'F', 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $bid->freelancer->name ?? 'Freelancer' }}</h6>
                                            <div class="text-muted small">
                                                <i class="bi bi-star-fill text-warning me-1"></i>
                                                <span>4.9 (125 reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="h5 text-success mb-0">${{ number_format($bid->amount ?? 0, 2) }}</div>
                                        <small class="text-muted">in {{ $bid->delivery_time ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                <p class="mb-3">{{ $bid->proposal ?? 'No proposal provided' }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>Submitted {{ $bid->created_at ? $bid->created_at->diffForHumans() : 'recently' }}
                                    </small>
                                    <div>
                                        @if($bid->freelancer)
                                            <a href="{{ route('messages.start', $bid->freelancer->id) }}" class="btn btn-sm btn-outline-info me-2" title="Chat with Freelancer">
                                                <i class="bi bi-chat-dots me-1"></i>Chat
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-outline-primary me-2">
                                            <i class="bi bi-eye me-1"></i>View Profile
                                        </button>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle me-1"></i>Accept Bid
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-3 text-muted"></i>
                            <p class="text-muted mt-3">No bids received yet. Share your job to attract more freelancers!</p>
                            <button class="btn btn-primary mt-2">
                                <i class="bi bi-share me-1"></i>Share This Job
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Budget & Timeline -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-cash-stack text-success me-2"></i>Budget & Timeline
                    </h6>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Budget Range</div>
                        <div class="h4 text-success mb-0">
                            ${{ number_format($job->budget_min) }} - ${{ number_format($job->budget_max) }}
                        </div>
                        <small class="text-muted">{{ $job->currency ?? 'USD' }}</small>
                    </div>

                    <hr>

                    @if($job->duration)
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Project Duration</div>
                        <div class="fw-bold">{{ $job->duration }}</div>
                    </div>
                    @endif

                    @if($job->expires_at)
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Expires On</div>
                        <div class="fw-bold">{{ $job->expires_at->format('M d, Y') }}</div>
                        <small class="text-muted">({{ $job->expires_at->diffForHumans() }})</small>
                    </div>
                    @endif

                    <div class="mb-0">
                        <div class="text-muted small mb-1">Category</div>
                        <span class="badge bg-primary">{{ $job->category }}</span>
                    </div>
                </div>
            </div>

            <!-- Activity Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-graph-up text-info me-2"></i>Activity Stats
                    </h6>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Views</span>
                        <strong>--</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Bids Received</span>
                        <strong>{{ $job->bids->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Average Bid</span>
                        <strong>
                            @if($job->bids->count() > 0)
                                ${{ number_format($job->bids->avg('amount') ?? 0, 2) }}
                            @else
                                --
                            @endif
                        </strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Lowest Bid</span>
                        <strong class="text-success">
                            @if($job->bids->count() > 0)
                                ${{ number_format($job->bids->min('amount') ?? 0, 2) }}
                            @else
                                --
                            @endif
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightning-charge text-warning me-2"></i>Quick Actions
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('client.jobs.messages', $job->id) }}" class="btn btn-primary">
                            <i class="bi bi-chat-dots me-1"></i>View Messages
                            @if($job->messages()->where('user_id', '!=', auth()->id())->where('is_read', false)->count() > 0)
                                <span class="badge bg-danger ms-2">
                                    {{ $job->messages()->where('user_id', '!=', auth()->id())->where('is_read', false)->count() }}
                                </span>
                            @endif
                        </a>
                        @if($job->status === 'open')
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-pause-circle me-1"></i>Close Bidding
                            </button>
                        @endif
                        <a href="{{ route('client.jobs.edit', $job->id) }}" class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-1"></i>Edit Job
                        </a>
                        <button class="btn btn-outline-info">
                            <i class="bi bi-share me-1"></i>Share Job
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat me-1"></i>Repost Job
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.job-description {
    font-size: 1rem;
    line-height: 1.8;
    color: #495057;
}

.bid-item {
    transition: all 0.3s ease;
    background-color: #fff;
}

.bid-item:hover {
    background-color: #f8f9fa;
    border-color: #667eea !important;
    transform: translateX(5px);
}

.card {
    border-radius: 0.75rem;
}
</style>
@endsection
