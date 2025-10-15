<!-- Modern Professional Header -->
<header class="bg-white shadow-sm border-bottom sticky-top">
    <div class="container-fluid px-4">
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container-fluid px-0">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="navbar-brand d-flex align-items-center">
                    <div class="bg-gradient-primary text-white rounded-3 d-flex align-items-center justify-content-center me-2"
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <span class="fw-bold fs-5">M</span>
                    </div>
                    <span class="fw-bold text-dark fs-4">Market<span class="text-primary">Fusion</span></span>
                </a>

                 <!-- Mobile Toggle Button -->
                 <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-expanded="false">
                     <span class="navbar-toggler-icon"></span>
                 </button>

                 <!-- Navigation Content -->
                 <div class="navbar-collapse show" id="navbarContent">
                     <!-- Center Navigation Links -->
                     <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                         <li class="nav-item">
                             <a class="nav-link {{ request()->is('/') ? 'active fw-semibold' : '' }}" href="{{ url('/') }}">
                                 <i class="bi bi-house-door me-1"></i>Home
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('jobs.index') ? 'active fw-semibold' : '' }}" href="{{ route('jobs.index') }}">
                                 <i class="bi bi-briefcase me-1"></i>Find Work
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('products.index') ? 'active fw-semibold' : '' }}" href="{{ route('products.index') }}">
                                 <i class="bi bi-cart me-1"></i>Marketplace
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('services.index') ? 'active fw-semibold' : '' }}" href="{{ route('services.index') }}">
                                 <i class="bi bi-tools me-1"></i>Services
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('freelancers.index') ? 'active fw-semibold' : '' }}" href="{{ route('freelancers.index') }}">
                                 <i class="bi bi-people me-1"></i>Freelancers
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-semibold' : '' }}" href="{{ route('contact') }}">
                                 <i class="bi bi-envelope me-1"></i>Contact
                             </a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('about') ? 'active fw-semibold' : '' }}" href="{{ route('about') }}">
                                 <i class="bi bi-info-circle me-1"></i>About
                             </a>
                         </li>
                     </ul>

                    <!-- Right Side -->
                    <div class="d-flex align-items-center gap-2">
                        @auth
                            <!-- Notifications -->
                            <div class="dropdown">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                        3
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width: 320px;">
                                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Notifications</span>
                                        <span class="badge bg-primary rounded-pill">3</span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item py-2" href="#">
                                            <div class="d-flex">
                                                <div class="me-2">
                                                    <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                        <i class="bi bi-check-circle text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold small">Order Completed</div>
                                                    <div class="text-muted small">Your order #1234 has been completed</div>
                                                    <div class="text-muted" style="font-size: 0.75rem;">2 hours ago</div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="text-center py-2">
                                        <a href="#" class="small text-decoration-none">View all notifications</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Messages -->
                            <div class="dropdown">
                                <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-chat-dots"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 0.6rem;">
                                        5
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width: 320px;">
                                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Messages</span>
                                        <span class="badge bg-success rounded-pill">5</span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li class="text-center py-2">
                                        <a href="#" class="small text-decoration-none">View all messages</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Role Switcher -->
                            @include('partials.role-switcher')

                            <!-- User Menu -->
                            <div class="dropdown">
                                <button class="btn btn-light d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <span class="fw-semibold small">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    </div>
                                    <span class="d-none d-lg-inline fw-semibold">{{ auth()->user()->name }}</span>
                                    <i class="bi bi-chevron-down small"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" style="min-width: 250px;">
                                    <li class="px-3 py-2 bg-light">
                                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                        <div class="small text-muted">{{ auth()->user()->email }}</div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}?view=all">
                                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                        </a>
                                    </li>
                                     <li>
                                         <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                             <i class="bi bi-person me-2"></i>Profile
                                         </a>
                                     </li>
                                     <li>
                                         <a class="dropdown-item" href="{{ route('downloads') }}">
                                             <i class="bi bi-download me-2"></i>My Downloads
                                         </a>
                                     </li>
                                     <li>
                                         <a class="dropdown-item" href="#">
                                             <i class="bi bi-wallet2 me-2"></i>Wallet
                                             <span class="badge bg-success ms-2">$0.00</span>
                                         </a>
                                     </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-gear me-2"></i>Settings
                                        </a>
                                    </li>
                                    @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-shield-check me-2"></i>Admin Panel
                                            </a>
                                        </li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Guest Buttons -->
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="bi bi-person-plus me-1"></i>Sign Up
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<style>
.navbar-nav .nav-link {
    color: #6c757d;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.navbar-nav .nav-link:hover {
    color: #667eea;
}

.navbar-nav .nav-link.active {
    color: #667eea;
}

.navbar-nav .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 1rem;
    right: 1rem;
    height: 2px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.dropdown-menu {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 0.5rem;
    margin-top: 0.5rem;
}

.dropdown-item {
    padding: 0.6rem 1rem;
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    padding-left: 1.2rem;
}

.btn-light {
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    transform: translateY(-1px);
}

header.sticky-top {
    z-index: 1020;
}

#navbarContent {
    display: flex !important;
}

@media (max-width: 991.98px) {
    #navbarContent {
        display: none !important;
    }

    #navbarContent.show {
        display: block !important;
    }
}
</style>
