@extends('layouts.freelancer')

@section('title', 'Freelancer Dashboard')

@section('page-title', 'Freelancer Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Gigs</h6>
                            <h3 class="mb-0 text-primary">{{ $stats['active_gigs'] }}</h3>
                        </div>
                        <div class="text-primary" style="font-size: 2rem;">
                            <i class="bi bi-tools"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Completed Jobs</h6>
                            <h3 class="mb-0 text-success">{{ $stats['completed_jobs'] }}</h3>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Earnings</h6>
                            <h3 class="mb-0 text-info">${{ number_format($stats['total_earnings'], 2) }}</h3>
                        </div>
                        <div class="text-info" style="font-size: 2rem;">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Pending Bids</h6>
                            <h3 class="mb-0 text-warning">{{ $stats['pending_bids'] }}</h3>
                        </div>
                        <div class="text-warning" style="font-size: 2rem;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        Quick Actions
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('freelancer.services.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Create New Gig
                        </a>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-search me-1"></i> Browse Jobs
                        </a>
                        <a href="{{ route('freelancer.proposals.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-file-earmark-text me-1"></i> My Proposals
                        </a>
                        <a href="{{ route('freelancer.earnings') }}" class="btn btn-outline-info">
                            <i class="bi bi-wallet2 me-1"></i> View Earnings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-briefcase me-2 text-primary"></i>
                            Active Jobs
                        </h5>
                        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($active_jobs) && $active_jobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Client</th>
                                        <th>Budget</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($active_jobs as $job)
                                        <tr>
                                            <td>
                                                <a href="{{ route('freelancer.jobs.show', $job->id) }}" class="text-decoration-none">
                                                    {{ Str::limit($job->title, 40) }}
                                                </a>
                                            </td>
                                            <td>{{ $job->client->name ?? 'N/A' }}</td>
                                            <td class="text-success fw-bold">${{ number_format($job->budget, 2) }}</td>
                                            <td>{{ $job->deadline ? $job->deadline->format('M d, Y') : 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $job->status === 'open' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($job->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">No active jobs yet. Start bidding on available jobs!</p>
                            <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-search me-1"></i> Browse Jobs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity & Tips -->
        <div class="col-md-4">
            <!-- Profile Completion -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-person-check text-primary me-2"></i>
                        Profile Completion
                    </h6>
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
                    </div>
                    <small class="text-muted">Complete your profile to get more jobs</small>
                    <div class="mt-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-pencil me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tips & Recommendations -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Tips for Success
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Respond to messages within 24 hours</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Keep your portfolio updated</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Write detailed proposals</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Deliver work on time</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
