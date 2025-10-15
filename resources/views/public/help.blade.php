@extends('layouts.guest')

@section('title', 'Help & Support')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">Help & Support</h1>
            <p class="lead text-muted">Find answers to common questions and get the help you need</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-primary text-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search for help...">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Help Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="text-center mb-4">Browse Help Topics</h3>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="card border-0 bg-light h-100 hover-lift">
                <div class="card-body">
                    <i class="bi bi-person-circle text-primary fs-1 mb-3"></i>
                    <h5>Getting Started</h5>
                    <p class="text-muted small">Learn how to set up your account and get started</p>
                    <a href="#getting-started" class="btn btn-outline-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 bg-light h-100 hover-lift">
                <div class="card-body">
                    <i class="bi bi-briefcase text-primary fs-1 mb-3"></i>
                    <h5>Finding Work</h5>
                    <p class="text-muted small">Tips for finding and winning projects</p>
                    <a href="#finding-work" class="btn btn-outline-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 bg-light h-100 hover-lift">
                <div class="card-body">
                    <i class="bi bi-credit-card text-primary fs-1 mb-3"></i>
                    <h5>Billing & Payments</h5>
                    <p class="text-muted small">Manage your payments and billing</p>
                    <a href="#billing" class="btn btn-outline-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 bg-light h-100 hover-lift">
                <div class="card-body">
                    <i class="bi bi-shield-check text-primary fs-1 mb-3"></i>
                    <h5>Account Security</h5>
                    <p class="text-muted small">Keep your account safe and secure</p>
                    <a href="#security" class="btn btn-outline-primary btn-sm">View Articles</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Articles -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4">Popular Articles</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="card-title">How to Create an Effective Freelancer Profile</h6>
                            <p class="card-text small text-muted">Learn how to create a profile that attracts clients and showcases your skills.</p>
                            <a href="#" class="small text-primary">Read more →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="card-title">Understanding Our Fee Structure</h6>
                            <p class="card-text small text-muted">Clear explanation of our platform fees and payment processing.</p>
                            <a href="#" class="small text-primary">Read more →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="card-title">Dispute Resolution Process</h6>
                            <p class="card-text small text-muted">How we handle disputes between freelancers and clients.</p>
                            <a href="#" class="small text-primary">Read more →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bi bi-star"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="card-title">Building Your Reputation</h6>
                            <p class="card-text small text-muted">Tips for getting great reviews and building client trust.</p>
                            <a href="#" class="small text-primary">Read more →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="row">
        <div class="col-12 text-center">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body p-5">
                    <h3 class="card-title mb-3">Still need help?</h3>
                    <p class="card-text fs-5 mb-4">
                        Our support team is here to help you succeed on our platform.
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-envelope me-2"></i>Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
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