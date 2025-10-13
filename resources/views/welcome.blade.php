<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- SEO Meta Tags -->
    <title>MarketFusion - Premium Freelance Services & Digital Marketplace</title>
    <meta name="description" content="Connect with talented freelancers, hire for jobs, and discover premium digital products. One platform for all your freelancing and digital product needs.">
    <meta name="keywords" content="freelance marketplace, digital products, hire freelancers, gigs, themes, plugins, web development, design services">
    <meta name="author" content="MarketFusion">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="MarketFusion - Premium Freelance Services & Digital Marketplace">
    <meta property="og:description" content="Connect with talented freelancers, hire for jobs, and discover premium digital products all in one marketplace.">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="MarketFusion - Premium Freelance Services & Digital Marketplace">
    <meta property="twitter:description" content="Connect with talented freelancers, hire for jobs, and discover premium digital products all in one marketplace.">
    <meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Hero Section with Gradient Animation */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
            min-height: 90vh;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 10;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.5rem);
            font-weight: 400;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }

        /* Product & Service Cards */
        .product-card, .service-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            height: 100%;
        }

        .product-card:hover, .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .product-card img {
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        /* Category Cards */
        .category-card {
            border: none;
            border-radius: 16px;
            padding: 2rem 1rem;
            text-align: center;
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f3f4f6);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            cursor: pointer;
            height: 100%;
        }

        .category-card:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.3);
        }

        .category-card:hover .category-icon {
            transform: scale(1.2) rotate(10deg);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        /* Stats Section */
        .stats-section {
            background: var(--dark-gradient);
            color: white;
            padding: 5rem 0;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
        }

        /* CTA Buttons */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.5);
            color: white;
        }

        .btn-outline-white {
            border: 2px solid white;
            color: white;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-white:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Section Titles */
        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60%;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        /* Badge Styles */
        .badge-featured {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-trending {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background: #1a1a2e;
            color: #eee;
        }

        footer a {
            color: #aaa;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #fff;
        }

        /* Search Bar */
        .hero-search {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-search input {
            border: none;
            background: transparent;
            padding: 0.8rem 1.5rem;
            font-size: 1.1rem;
        }

        .hero-search input:focus {
            outline: none;
            box-shadow: none;
        }

        .hero-search .btn {
            border-radius: 50px;
            padding: 0.8rem 2rem;
        }

        /* Price Tag */
        .price-tag {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }

        /* Avatar */
        .avatar-sm {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 70vh;
                padding: 3rem 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>

   
</head>
<body>

    @include('partials.header')

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container hero-content">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="hero-title text-white" data-aos="fade-up">
                        One Platform, <br>
                        <span class="text-warning">Endless Opportunities</span>
                    </h1>
                    <p class="hero-subtitle text-white" data-aos="fade-up" data-aos-delay="100">
                        Connect with talented freelancers, hire for jobs, and discover premium digital products all in one marketplace
                    </p>

                    <!-- Search Bar -->
                    <div class="hero-search mb-5" data-aos="fade-up" data-aos-delay="200">
                        <form action="#" method="GET" class="d-flex align-items-center">
                            <input type="text" name="q" class="form-control flex-grow-1" placeholder="Search for services, products, or freelancers...">
                            <button type="submit" class="btn btn-primary-gradient ms-2">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                        </form>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="d-flex justify-content-center gap-3 mb-5" data-aos="fade-up" data-aos-delay="300">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary-gradient">
                                <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary-gradient">
                                <i class="bi bi-rocket-takeoff me-2"></i>Get Started Free
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-white">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </a>
                        @endauth
                    </div>

                    <!-- Stats Cards -->
                    <div class="row text-center mt-5 g-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="col-6 col-md-3">
                            <div class="glass-card">
                                <div class="h2 fw-bold mb-2 text-white">{{ number_format($stats['total_users'] ?? 0) }}+</div>
                                <div class="text-white-50">Active Users</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="glass-card">
                                <div class="h2 fw-bold mb-2 text-white">{{ number_format($stats['total_services'] ?? 0) }}+</div>
                                <div class="text-white-50">Active Services</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="glass-card">
                                <div class="h2 fw-bold mb-2 text-white">{{ number_format($stats['total_products'] ?? 0) }}+</div>
                                <div class="text-white-50">Digital Products</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="glass-card">
                                <div class="h2 fw-bold mb-2 text-white">{{ number_format($stats['total_freelancers'] ?? 0) }}+</div>
                                <div class="text-white-50">Freelancers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories Section -->
    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Popular Categories</h2>
                <p class="lead text-muted">Explore trending categories in our marketplace</p>
            </div>

            <div class="row g-4">
                @php
                    $categories = [
                        ['name' => 'Web Development', 'icon' => 'bi-code-slash', 'color' => '#667eea'],
                        ['name' => 'Mobile Apps', 'icon' => 'bi-phone', 'color' => '#764ba2'],
                        ['name' => 'UI/UX Design', 'icon' => 'bi-palette', 'color' => '#f093fb'],
                        ['name' => 'Graphic Design', 'icon' => 'bi-brush', 'color' => '#f5576c'],
                        ['name' => 'Digital Marketing', 'icon' => 'bi-megaphone', 'color' => '#4facfe'],
                        ['name' => 'Content Writing', 'icon' => 'bi-pen', 'color' => '#00f2fe'],
                        ['name' => 'Video Editing', 'icon' => 'bi-film', 'color' => '#43e97b'],
                        ['name' => 'SEO Services', 'icon' => 'bi-graph-up', 'color' => '#38f9d7'],
                    ];
                @endphp

                @foreach($categories as $index => $category)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="category-card">
                        <i class="bi {{ $category['icon'] }} category-icon" style="color: {{ $category['color'] }};"></i>
                        <h5 class="mb-0">{{ $category['name'] }}</h5>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    @if($featuredProducts && $featuredProducts->count() > 0)
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Featured Digital Products</h2>
                <p class="lead text-muted">Premium themes, plugins, and digital assets from top creators</p>
            </div>

            <div class="row g-4">
                @foreach($featuredProducts as $index => $product)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="card product-card">
                        <div class="position-relative overflow-hidden">
                            @if($product->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $product->getFirstMediaUrl('thumbnail') }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="https://via.placeholder.com/400x300/667eea/ffffff?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            @if($product->is_featured)
                                <span class="badge badge-featured position-absolute top-0 end-0 m-3">
                                    <i class="bi bi-star-fill me-1"></i>Featured
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-2">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <span class="fw-medium small">{{ strtoupper(substr($product->user->name ?? 'U', 0, 1)) }}</span>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $product->user->name ?? 'Unknown' }}</small>
                            </div>
                            <h5 class="card-title mb-2">{{ Str::limit($product->name, 50) }}</h5>
                            <p class="card-text text-muted small mb-3">{{ Str::limit($product->short_description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="price-tag">${{ number_format($product->standard_price, 2) }}</div>
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">4.8</span>
                                    <span class="text-muted small">({{ rand(50, 500) }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="#" class="btn btn-primary w-100">
                                <i class="bi bi-cart-plus me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-primary-gradient btn-lg">
                    <i class="bi bi-grid me-2"></i><a href="{{ route('products.index') }}" class="text-decoration-none">Browse All Products</a>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Trending Services Section -->
    @if($trendingServices && $trendingServices->count() > 0)
    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Trending Services</h2>
                <p class="lead text-muted">Popular gigs from talented freelancers</p>
            </div>

            <div class="row g-4">
                @foreach($trendingServices as $index => $service)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="card service-card">
                        <div class="position-relative overflow-hidden">
                            @if(is_array($service->images) && count($service->images) > 0)
                                <img src="{{ asset('storage/' . $service->images[0]) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $service->title }}">
                            @else
                                <img src="https://via.placeholder.com/400x300/764ba2/ffffff?text={{ urlencode($service->title) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $service->title }}">
                            @endif
                            <span class="badge badge-trending position-absolute top-0 end-0 m-3">
                                <i class="bi bi-fire me-1"></i>Trending
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-2">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <span class="fw-medium small">{{ strtoupper(substr($service->user->name ?? 'U', 0, 1)) }}</span>
                                    </div>
                                </div>
                                <small class="text-muted">{{ $service->user->name ?? 'Unknown' }}</small>
                            </div>
                            <h5 class="card-title mb-2">{{ Str::limit($service->title, 50) }}</h5>
                            <p class="card-text text-muted small mb-3">{{ Str::limit($service->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted small">Starting at</span>
                                    <div class="price-tag">${{ number_format($service->price, 2) }}</div>
                                </div>
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-bold">4.9</span>
                                    <span class="text-muted small">({{ rand(20, 200) }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye me-2"></i>View Service
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-primary-gradient btn-lg">
                    <i class="bi bi-briefcase me-2"></i>Browse All Services
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- How It Works Section -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">How It Works</h2>
                <p class="lead text-muted">Get started in three simple steps</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="text-center p-4">
                        <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-plus fs-1"></i>
                        </div>
                        <h4 class="mb-3">1. Create Account</h4>
                        <p class="text-muted">Sign up for free and set up your profile in minutes</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-center p-4">
                        <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-search fs-1"></i>
                        </div>
                        <h4 class="mb-3">2. Find Services</h4>
                        <p class="text-muted">Browse thousands of services and digital products</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center p-4">
                        <div class="bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-rocket-takeoff fs-1"></i>
                        </div>
                        <h4 class="mb-3">3. Start Working</h4>
                        <p class="text-muted">Hire talent or start selling your own services</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="0">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_users'] ?? 0) }}+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_products'] ?? 0) }}+</div>
                        <div class="stat-label">Digital Products</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_services'] ?? 0) }}+</div>
                        <div class="stat-label">Active Services</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-number">4.9/5</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h2 class="display-4 fw-bold mb-3">Ready to Get Started?</h2>
                    <p class="lead text-muted mb-4">Join thousands of freelancers and businesses already using MarketFusion to grow their business and achieve their goals.</p>
                </div>
                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary-gradient btn-lg">
                            <i class="bi bi-rocket-takeoff me-2"></i>Join Now - It's Free
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-gradient btn-lg">
                            <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="fw-bold mb-3 text-white">MarketFusion</h4>
                    <p class="text-muted">Your one-stop marketplace for freelance services and premium digital products. Connecting talent with opportunity worldwide.</p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="#" class="text-white fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-semibold mb-3 text-white">For Clients</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">Find Freelancers</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Post a Job</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-decoration-none">Digital Products</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">How It Works</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-semibold mb-3 text-white">For Freelancers</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">Find Jobs</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Create Profile</a></li>
                        <li class="mb-2"><a href="{{ route('vendor.products.index') }}" class="text-decoration-none">Sell Products</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Success Stories</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-semibold mb-3 text-white">Company</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Careers</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Press</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4">
                    <h6 class="fw-semibold mb-3 text-white">Support</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Contact Us</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Terms of Service</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} MarketFusion. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">Made with <i class="bi bi-heart-fill text-danger"></i> for freelancers worldwide</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>
