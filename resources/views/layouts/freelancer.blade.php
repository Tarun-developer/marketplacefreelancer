<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Freelancer Dashboard') - MarketFusion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar {
            width: 250px;
            transition: all 0.3s;
        }
        .sidebar.collapsed {
            width: 70px;
        }
        .sidebar.collapsed .nav-link span {
            display: none;
        }
        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }
        .main-content.expanded {
            margin-left: 70px;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        /* Theme Variables */
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        .theme-dark {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #1a1a1a;
            --dark-color: #ffffff;
        }
        body {
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        .sidebar {
            background-color: var(--secondary-color);
        }
        .navbar-brand, .nav-link {
            color: var(--dark-color) !important;
        }
        .card {
            background-color: var(--light-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="d-flex">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar bg-dark text-white vh-100 position-fixed">
            <div class="p-3 border-bottom border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" id="sidebar-title">Freelancer Panel</h5>
                    <button class="btn btn-outline-light btn-sm" id="sidebar-toggle">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                </div>
            </div>
            <div class="p-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('freelancer.dashboard') }}" class="nav-link text-white {{ request()->routeIs('freelancer.dashboard') ? 'active bg-secondary' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('freelancer.jobs.index') }}" class="nav-link text-white {{ request()->routeIs('freelancer.jobs.*') ? 'active bg-secondary' : '' }}">
                            <i class="bi bi-briefcase me-2"></i><span>Jobs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('freelancer.proposals.index') }}" class="nav-link text-white {{ request()->routeIs('freelancer.proposals.*') ? 'active bg-secondary' : '' }}">
                            <i class="bi bi-file-earmark-text me-2"></i><span>Proposals</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('freelancer.services.index') }}" class="nav-link text-white {{ request()->routeIs('freelancer.services.*') ? 'active bg-secondary' : '' }}">
                            <i class="bi bi-tools me-2"></i><span>Gigs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('freelancer.earnings') }}" class="nav-link text-white">
                            <i class="bi bi-currency-dollar me-2"></i><span>Earnings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="main-content" class="main-content flex-fill">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-3 d-md-none" id="mobile-sidebar-toggle">
                            <i class="bi bi-list"></i>
                        </button>
                        <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @include('partials.role-switcher')
                        <button class="btn btn-outline-secondary btn-sm" id="theme-toggle" title="Toggle theme">
                            <i class="bi bi-moon-stars"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2"
                                    type="button"
                                    id="userDropdown"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
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
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const title = document.getElementById('sidebar-title');
            const toggleIcon = this.querySelector('i');

            if (sidebar.classList.contains('collapsed')) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
                title.style.display = 'block';
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-left');
            } else {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                title.style.display = 'none';
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
            }
        });

        document.getElementById('mobile-sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        });

        // Theme Toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.body.classList.toggle('theme-dark');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('theme-dark')) {
                icon.className = 'bi bi-sun';
            } else {
                icon.className = 'bi bi-moon-stars';
            }
        });
    </script>
    @yield('scripts')
</body>
</html>