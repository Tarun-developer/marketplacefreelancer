@extends('layouts.freelancer')

@section('title', $job->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('freelancer.jobs.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Jobs
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">{{ Str::limit($job->title, 30) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Job Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-briefcase fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $job->title }}</h2>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>Posted by {{ $job->client->name ?? 'N/A' }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }} me-2">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst($job->status) }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>Expires: {{ $job->expires_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Project Description
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $job->description }}</p>
                                </div>
                            </div>

                            @if($job->skills_required)
                                <div class="mt-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-tags me-2 text-primary"></i>Required Skills
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($job->skills_required as $skill)
                                            <span class="badge bg-outline-primary px-3 py-2">
                                                <i class="fas fa-check-circle me-1"></i>{{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Job Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Project Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-folder me-2"></i>Category:</span>
                                        <strong>{{ $job->category }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-dollar-sign me-2"></i>Budget:</span>
                                        <strong>${{ number_format($job->budget_min, 2) }} - ${{ number_format($job->budget_max, 2) }} {{ $job->currency }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-calendar me-2"></i>Duration:</span>
                                        <strong>{{ $job->duration }} days</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bidding Form -->
                    @if(auth()->check())
                        @if(!App\Models\Bid::where('job_id', $job->id)->where('freelancer_id', auth()->id())->exists())
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-3">
                                        <i class="fas fa-gavel me-2 text-primary"></i>Submit Your Bid
                                    </h5>
                                    <form action="{{ route('freelancer.jobs.storeBid', $job) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="proposal" class="form-label fw-bold">
                                                <i class="fas fa-edit me-2"></i>Your Proposal
                                            </label>
                                            <textarea class="form-control" id="proposal" name="proposal" rows="5" placeholder="Describe how you'll approach this project..." required></textarea>
                                            <div class="form-text">Provide a detailed proposal to increase your chances of being selected.</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="price" class="form-label fw-bold">
                                                    <i class="fas fa-tag me-2"></i>Bid Price ($)
                                                </label>
                                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" placeholder="0.00" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="duration" class="form-label fw-bold">
                                                    <i class="fas fa-hourglass-half me-2"></i>Duration (days)
                                                </label>
                                                <input type="number" class="form-control" id="duration" name="duration" min="1" placeholder="1" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Bid
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-check-circle text-success fa-3x"></i>
                                    </div>
                                    <h5 class="text-success">Bid Submitted!</h5>
                                    <p class="text-muted">You have already submitted a bid for this job. You'll be notified if the client selects you.</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4 text-center">
                                <div class="mb-3">
                                    <i class="fas fa-lock fa-3x text-muted"></i>
                                </div>
                                <h5>Login Required</h5>
                                <p class="text-muted mb-3">You need to be logged in to submit a bid.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection