@extends('layouts.freelancer')

@section('title', 'Proposal Details')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('freelancer.proposals.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>My Proposals
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">Proposal Details</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Proposal Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-file-alt fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $proposal->job->title ?? 'N/A' }}</h2>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>Your Proposal
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $proposal->status == 'accepted' ? 'success' : ($proposal->status == 'rejected' ? 'danger' : 'secondary') }} me-2">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Your Proposal
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $proposal->proposal }}</p>
                                </div>
                            </div>

                            @if($proposal->job->description ?? false)
                                <div class="mt-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-info-circle me-2 text-primary"></i>Job Description
                                    </h5>
                                    <div class="bg-light p-3 rounded">
                                        <p class="mb-0">{{ $proposal->job->description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Proposal Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Proposal Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-dollar-sign me-2"></i>Bid Price:</span>
                                        <strong>${{ number_format($proposal->price, 2) }} {{ $proposal->currency }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-calendar me-2"></i>Duration:</span>
                                        <strong>{{ $proposal->duration }} days</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-clock me-2"></i>Submitted:</span>
                                        <strong>{{ $proposal->created_at->format('M d, Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-cogs me-2 text-primary"></i>Actions
                            </h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('freelancer.jobs.show', $proposal->job) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye me-2"></i>View Job Details
                                </a>
                                @if($proposal->status == 'pending')
                                    <button class="btn btn-outline-secondary" disabled>
                                        <i class="fas fa-hourglass-half me-2"></i>Awaiting Response
                                    </button>
                                @elseif($proposal->status == 'accepted')
                                    <a href="#" class="btn btn-success">
                                        <i class="fas fa-check me-2"></i>Accepted - Start Work
                                    </a>
                                @else
                                    <button class="btn btn-outline-danger" disabled>
                                        <i class="fas fa-times me-2"></i>Rejected
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection