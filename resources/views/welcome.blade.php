<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketFusion - Freelance & Digital Marketplace</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    @include('partials.header')

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 80vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="display-1 fw-bold mb-4">
                        One Platform, <span class="text-warning">Endless Opportunities</span>
                    </h1>
                    <p class="lead mb-4 text-light">
                        Connect with talented freelancers, hire for jobs, and discover premium digital products all in one marketplace
                    </p>
                    <div class="d-flex justify-content-center gap-3 mb-5">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg fw-bold">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold">
                                Get Started Free
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg fw-bold">
                                Sign In
                            </a>
                        @endauth
                    </div>
                    <div class="row text-center mt-5">
                        <div class="col-md-4">
                            <div class="h2 fw-bold mb-2">{{ \App\Models\User::count() }}+</div>
                            <div class="text-light">Active Users</div>
                        </div>
                        <div class="col-md-4">
                            <div class="h2 fw-bold mb-2">{{ \App\Modules\Services\Models\Service::where('status', 'active')->count() }}+</div>
                            <div class="text-light">Active Services</div>
                        </div>
                        <div class="col-md-4">
                            <div class="h2 fw-bold mb-2">{{ \App\Modules\Products\Models\Product::where('is_approved', true)->count() }}+</div>
                            <div class="text-light">Digital Products</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="h1 fw-bold text-center mb-5">Why Choose MarketFusion?</h2>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="display-4 text-primary mb-3">🚀</div>
                            <h5 class="card-title">Fast & Secure</h5>
                            <p class="card-text">Lightning-fast transactions with top-notch security</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="display-4 text-primary mb-3">💼</div>
                            <h5 class="card-title">Diverse Services</h5>
                            <p class="card-text">From freelancing gigs to digital products</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="display-4 text-primary mb-3">🌍</div>
                            <h5 class="card-title">Global Reach</h5>
                            <p class="card-text">Connect with clients and sellers worldwide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="h1 fw-bold text-center mb-5">Popular Categories</h2>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card h-100 text-center shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="display-5 mb-3">💻</div>
                            <h5 class="card-title">Web Development</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="display-5 mb-3">🎨</div>
                            <h5 class="card-title">Design</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="display-5 mb-3">📱</div>
                            <h5 class="card-title">Mobile Apps</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 text-center shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="display-5 mb-3">📊</div>
                            <h5 class="card-title">Marketing</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="h1 fw-bold mb-4">Ready to Get Started?</h2>
            <p class="lead mb-4">Join thousands of freelancers and businesses already using MarketFusion</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold">Join Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="fw-bold mb-3">MarketFusion</h5>
                    <p>Your one-stop marketplace for freelance services and digital products.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-semibold mb-3">Services</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Find Freelancers</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Post a Job</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Digital Products</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-semibold mb-3">Support</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="fw-semibold mb-3">Connect</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-4">📘</a>
                        <a href="#" class="text-white fs-4">🐦</a>
                        <a href="#" class="text-white fs-4">💼</a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; 2025 MarketFusion. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>