<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - MarketFusion</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap Icons -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
     <!-- Bootstrap Tags Input -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet">
     <!-- Google Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --danger-gradient: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: #1e293b;
            box-shadow: 0 0 30px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-gradient);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            flex-shrink: 0;
        }

        .sidebar-logo-text {
            font-weight: 600;
            font-size: 18px;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .sidebar-logo-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-toggle {
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .sidebar-toggle:hover {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-menu {
            padding: 20px 10px;
        }

        .menu-section-title {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 15px 8px;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.3s;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .menu-item.active {
            background: var(--primary-gradient);
            color: #fff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .menu-item i {
            font-size: 20px;
            width: 24px;
            flex-shrink: 0;
        }

        .menu-item span {
            margin-left: 12px;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed .menu-item span {
            opacity: 0;
            width: 0;
            margin: 0;
        }

        .menu-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: 600;
        }

        .sidebar.collapsed .menu-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 8px;
            padding: 2px 4px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.collapsed + .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Header */
        .top-header {
            background: #fff;
            height: var(--header-height);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: none;
            background: #f8f9fc;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .header-btn:hover {
            background: #e2e8f0;
            color: #334155;
        }

        .header-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
        }

        .user-menu-btn {
            background: var(--primary-gradient);
            color: #fff;
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-menu-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar.collapsed + .main-content {
                margin-left: 0;
            }

            .top-header {
                padding: 0 15px;
            }

            .content-area {
                padding: 20px 15px;
            }

            .header-title {
                font-size: 18px;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Cards */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}?view=all" class="sidebar-logo">
                <div class="sidebar-logo-icon">M</div>
                <span class="sidebar-logo-text">MarketFusion</span>
            </a>
            <button class="sidebar-toggle d-none d-md-flex" id="sidebarToggle">
                <i class="bi bi-chevron-left"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            @yield('sidebar-menu')
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="header-btn d-md-none" id="mobileSidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h1 class="header-title">@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="header-actions">
                <!-- Search -->
                <button class="header-btn d-none d-lg-flex" title="Search">
                    <i class="bi bi-search"></i>
                </button>

                <!-- Notifications -->
                <button class="header-btn" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="badge">3</span>
                </button>

                <!-- Messages -->
                <button class="header-btn d-none d-md-flex" title="Messages">
                    <i class="bi bi-chat-dots"></i>
                    <span class="badge">5</span>
                </button>

                <!-- Role Switcher -->
                @include('partials.role-switcher')

                <!-- User Menu -->
                <div class="dropdown">
                    <button class="user-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" style="min-width: 220px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="small text-muted">Signed in as</div>
                            <div class="fw-semibold">{{ auth()->user()->email }}</div>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i>My Profile
                        </a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}?view=all">
                            <i class="bi bi-speedometer2 me-2"></i>User Dashboard
                        </a></li>
                        <li><a class="dropdown-item py-2" href="#">
                            <i class="bi bi-gear me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

     <script>
        // Sidebar Toggle (Desktop)
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const icon = this.querySelector('i');

            sidebar.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
            }
        });

        // Mobile Sidebar Toggle
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebar = document.getElementById('sidebar');

        function toggleMobileSidebar() {
            sidebar.classList.toggle('mobile-show');
            sidebarOverlay.classList.toggle('show');
        }

        mobileSidebarToggle.addEventListener('click', toggleMobileSidebar);
        sidebarOverlay.addEventListener('click', toggleMobileSidebar);

        // Close mobile sidebar when clicking a menu item
        document.querySelectorAll('.sidebar .menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    toggleMobileSidebar();
                }
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
