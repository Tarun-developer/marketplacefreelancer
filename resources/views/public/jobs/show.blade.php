@extends('layouts.guest')

@section('title', $job->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('jobs.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Find Work
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
                                        <i class="fas fa-user me-2"></i>Posted by {{ $job->client->name ?? 'Client' }}
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

                    <!-- Apply Button -->
                    @auth
                        @if(auth()->user()->hasRole('freelancer'))
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4 text-center">
                                    <h5 class="card-title mb-3">
                                        <i class="fas fa-gavel me-2 text-primary"></i>Submit Your Proposal
                                    </h5>
                                    <a href="{{ route('freelancer.jobs.show', $job) }}" class="btn btn-primary w-100 py-2">
                                        <i class="fas fa-paper-plane me-2"></i>Apply for this Job
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-lock fa-3x text-muted"></i>
                                    </div>
                                    <h5>Login Required</h5>
                                    <p class="text-muted mb-3">You need to be logged in as a freelancer to apply for jobs.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login as Freelancer
                                    </a>
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
                                <p class="text-muted mb-3">You need to be logged in to apply for jobs.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Apply
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection