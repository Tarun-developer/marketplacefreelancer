@extends('layouts.guest')

@section('title', $user->name . ' - Freelancer Profile')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('freelancers.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Freelancers
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">{{ $user->name }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Profile Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-4">
                                <div class="me-4">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                        <span class="fw-bold fs-3">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $user->name }}</h2>
                                    <p class="text-muted mb-2">{{ $user->profile->title ?? 'Freelancer' }}</p>
                                    <p class="mb-3">{{ $user->profile->bio ?? 'No bio available' }}</p>

                                    @if($user->profile->location)
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-map-marker-alt me-2"></i>{{ $user->profile->location }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($user->services->count() > 0)
                                <hr class="my-4">

                                <div>
                                    <h5 class="mb-3">
                                        <i class="fas fa-tools me-2 text-primary"></i>Services Offered
                                    </h5>
                                    <div class="row">
                                        @foreach($user->services->take(6) as $service)
                                            <div class="col-md-6 mb-3">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ Str::limit($service->title, 30) }}</h6>
                                                        <p class="card-text small text-muted">{{ Str::limit($service->description, 50) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="badge bg-primary">{{ $service->category->name ?? 'General' }}</span>
                                                            <strong class="text-success">${{ number_format($service->price, 2) }}</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($user->services->count() > 6)
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">View All Services</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Profile Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Profile Summary
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-star me-2"></i>Rating:</span>
                                        <strong>4.8/5</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-briefcase me-2"></i>Projects Completed:</span>
                                        <strong>{{ $user->ordersAsSeller()->where('status', 'completed')->count() }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-clock me-2"></i>Member Since:</span>
                                        <strong>{{ $user->created_at->format('M Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Actions -->
                    @auth
                        @if(auth()->user()->hasRole('client'))
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4 text-center">
                                    <h5 class="card-title mb-3">
                                        <i class="fas fa-comments me-2 text-primary"></i>Contact Freelancer
                                    </h5>
                                    <a href="{{ route('client.jobs.create') }}" class="btn btn-primary w-100 mb-2">
                                        <i class="fas fa-plus me-2"></i>Post a Job
                                    </a>
                                    <a href="{{ route('client.services.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-search me-2"></i>Browse Services
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4 text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-lock fa-3x text-muted"></i>
                                    </div>
                                    <h5>Client Access Required</h5>
                                    <p class="text-muted mb-3">You need to be logged in as a client to hire freelancers.</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login as Client
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
                                <p class="text-muted mb-3">You need to be logged in to contact freelancers.</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Continue
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