@extends('layouts.guest')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary mb-3">About MarketFusion</h1>
            <p class="lead text-muted">Connecting freelancers and clients worldwide</p>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 bg-gradient-primary text-white">
                <div class="card-body p-5 text-center">
                    <h2 class="card-title mb-4">Our Mission</h2>
                    <p class="card-text fs-5">
                        To create the world's most trusted freelance marketplace where talented professionals
                        can connect with clients, build successful careers, and deliver exceptional work.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Story Section -->
    <div class="row mb-5">
        <div class="col-lg-6">
            <h3 class="mb-4">Our Story</h3>
            <p class="mb-4">
                Founded in 2023, MarketFusion was born from the vision of creating a more transparent,
                efficient, and fair marketplace for freelance work. We recognized that both freelancers
                and clients were struggling with unreliable platforms, high fees, and poor support.
            </p>
            <p class="mb-4">
                Today, we've grown to become one of the leading freelance marketplaces, serving thousands
                of professionals and businesses worldwide. Our commitment to quality, security, and
                user experience remains at the heart of everything we do.
            </p>
        </div>
        <div class="col-lg-6">
            <img src="https://via.placeholder.com/600x400/667eea/ffffff?text=Our+Team" alt="Our Team" class="img-fluid rounded shadow">
        </div>
    </div>

    <!-- Values Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="text-center mb-5">Our Values</h3>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body">
                    <i class="bi bi-shield-check text-primary fs-1 mb-3"></i>
                    <h5>Trust & Security</h5>
                    <p class="text-muted">We prioritize the security and privacy of our users with industry-leading protection measures.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body">
                    <i class="bi bi-people text-primary fs-1 mb-3"></i>
                    <h5>Community First</h5>
                    <p class="text-muted">We build features and policies that benefit our entire community of freelancers and clients.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 bg-light h-100">
                <div class="card-body">
                    <i class="bi bi-graph-up text-primary fs-1 mb-3"></i>
                    <h5>Growth & Success</h5>
                    <p class="text-muted">We provide tools and opportunities for freelancers to grow their careers and businesses to scale.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <div class="row">
                        <div class="col-md-3">
                            <h2 class="display-6 fw-bold mb-2">50K+</h2>
                            <p class="mb-0">Freelancers</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-6 fw-bold mb-2">100K+</h2>
                            <p class="mb-0">Projects Completed</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-6 fw-bold mb-2">150+</h2>
                            <p class="mb-0">Countries</p>
                        </div>
                        <div class="col-md-3">
                            <h2 class="display-6 fw-bold mb-2">98%</h2>
                            <p class="mb-0">Satisfaction Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h3 class="mb-5">Meet Our Team</h3>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fw-bold fs-4">JD</span>
                    </div>
                    <h5>John Doe</h5>
                    <p class="text-muted">CEO & Founder</p>
                    <p class="small">Visionary leader with 10+ years in tech and marketplaces.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fw-bold fs-4">JS</span>
                    </div>
                    <h5>Jane Smith</h5>
                    <p class="text-muted">CTO</p>
                    <p class="small">Technical architect ensuring platform scalability and security.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0">
                <div class="card-body">
                    <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <span class="fw-bold fs-4">MB</span>
                    </div>
                    <h5>Mike Brown</h5>
                    <p class="text-muted">Head of Community</p>
                    <p class="small">Building relationships and ensuring user satisfaction.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection