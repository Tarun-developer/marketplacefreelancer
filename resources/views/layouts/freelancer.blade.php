<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Freelancer Dashboard') - {{ config('app.name', 'Marketplace') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Custom Styles -->
    <style>
        :root {
            /* Royal Color Palette */
            --royal-purple: #6B46C1;
            --royal-blue: #4C51BF;
            --deep-purple: #553C9A;
            --gold: #F6AD55;
            --light-gold: #FBD38D;
            --dark-bg: #1A202C;
            --sidebar-bg: linear-gradient(180deg, #2D3748 0%, #1A202C 100%);
            --accent-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

            /* Freelancer-specific colors */
            --freelancer-primary: #38B2AC;
            --freelancer-accent: #4FD1C5;
            --freelancer-light: #B2F5EA;

            /* Status Colors */
            --success-green: #48BB78;
            --warning-orange: #ED8936;
            --danger-red: #F56565;
            --info-blue: #4299E1;

            /* Text Colors */
            --text-light: #E2E8F0;
            --text-muted: #A0AEC0;
            --text-dark: #2D3748;

            /* Layout */
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --topbar-height: 70px;

            /* Transitions */
            --transition-speed: 0.3s;
            --transition-smooth: cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #F7FAFC;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: var(--text-light);
            transition: all var(--transition-speed) var(--transition-smooth);
            z-index: 1000;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Logo Section */
        .sidebar-logo {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(56, 178, 172, 0.2);
        }

        .sidebar-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(56, 178, 172, 0.4);
        }

        .sidebar-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-light);
            white-space: nowrap;
            transition: opacity var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed .sidebar-logo-text {
            opacity: 0;
            width: 0;
        }

        /* User Profile Section */
        .sidebar-user {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(56, 178, 172, 0.1);
        }

        .sidebar-user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            border: 2px solid var(--freelancer-primary);
            flex-shrink: 0;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(56, 178, 172, 0.3);
        }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
            transition: opacity var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed .sidebar-user-info {
            opacity: 0;
            width: 0;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-light);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.75rem;
            color: var(--freelancer-light);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.25rem;
        }

        .sidebar-user-role i {
            font-size: 0.7rem;
        }

        /* Menu Styles */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            padding: 0.75rem 1.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            transition: opacity var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed .menu-section-title {
            opacity: 0;
            height: 0;
            padding: 0;
            overflow: hidden;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s var(--transition-smooth);
            position: relative;
            cursor: pointer;
        }

        .menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            transform: scaleY(0);
            transition: transform 0.2s var(--transition-smooth);
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--freelancer-light);
        }

        .menu-item:hover::before {
            transform: scaleY(1);
        }

        .menu-item.active {
            background: rgba(56, 178, 172, 0.2);
            color: var(--freelancer-light);
            font-weight: 600;
        }

        .menu-item.active::before {
            transform: scaleY(1);
        }

        .menu-item i {
            width: 24px;
            font-size: 1.25rem;
            flex-shrink: 0;
            text-align: center;
        }

        .menu-item span {
            flex: 1;
            white-space: nowrap;
            transition: opacity var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed .menu-item span {
            opacity: 0;
            width: 0;
        }

        .menu-badge {
            background: var(--danger-red);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            min-width: 20px;
            text-align: center;
            transition: opacity var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed .menu-badge {
            opacity: 0;
            width: 0;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left var(--transition-speed) var(--transition-smooth);
        }

        .sidebar.collapsed ~ .main-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Bar */
        .top-bar {
            background: white;
            height: var(--topbar-height);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .sidebar-toggle {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s var(--transition-smooth);
            box-shadow: 0 2px 8px rgba(56, 178, 172, 0.3);
        }

        .sidebar-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(56, 178, 172, 0.4);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-bar-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: #F7FAFC;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s var(--transition-smooth);
            position: relative;
        }

        .top-bar-icon:hover {
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            color: white;
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger-red);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 0.15rem 0.4rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 12px;
            background: #F7FAFC;
            cursor: pointer;
            transition: all 0.2s var(--transition-smooth);
        }

        .user-menu:hover {
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            color: white;
        }

        .user-menu img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }

        .user-menu-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s var(--transition-smooth);
        }

        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .page-title {
                font-size: 1.25rem;
            }

            .top-bar {
                padding: 0 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .user-menu-name {
                display: none;
            }
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .menu-item {
            animation: slideIn 0.3s var(--transition-smooth);
        }

        /* Logout Button */
        .menu-logout {
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1rem;
        }

        .menu-logout .menu-item {
            color: var(--danger-red);
        }

        .menu-logout .menu-item:hover {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger-red);
        }

        /* Alert Styles */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
        }

        .alert-danger {
            background: rgba(245, 101, 101, 0.1);
            color: var(--danger-red);
        }

        .alert-warning {
            background: rgba(237, 137, 54, 0.1);
            color: var(--warning-orange);
        }

        .alert-info {
            background: rgba(66, 153, 225, 0.1);
            color: var(--info-blue);
        }

        /* Button Styles */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s var(--transition-smooth);
        }

        .btn-primary {
            background: linear-gradient(135deg, #38B2AC 0%, #4FD1C5 100%);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(56, 178, 172, 0.4);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="sidebar-logo-text">Freelancer Hub</div>
        </div>

        <!-- User Profile -->
        <div class="sidebar-user">
            <img src="{{ auth()->user()->getFirstMediaUrl('avatar', 'thumb') ?: asset('images/default-avatar.png') }}"
                 alt="Avatar"
                 class="sidebar-user-avatar">
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">
                    <i class="bi bi-patch-check"></i>
                    <span>Freelancer</span>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav class="sidebar-menu">
            <!-- Overview Section -->
            <div class="menu-section">
                <div class="menu-section-title">Overview</div>
                <a href="{{ route('freelancer.dashboard') }}" class="menu-item {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Work Section -->
            <div class="menu-section">
                <div class="menu-section-title">Find Work</div>
                <a href="{{ route('freelancer.jobs.index') }}" class="menu-item {{ request()->routeIs('freelancer.jobs.*') ? 'active' : '' }}">
                    <i class="bi bi-search"></i>
                    <span>Browse Jobs</span>
                </a>
                <a href="{{ route('freelancer.proposals.index') }}" class="menu-item {{ request()->routeIs('freelancer.proposals.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>My Proposals</span>
                    @if(auth()->user()->bids()->where('status', 'pending')->count() > 0)
                        <span class="menu-badge">{{ auth()->user()->bids()->where('status', 'pending')->count() }}</span>
                    @endif
                </a>
                <a href="{{ route('freelancer.projects.index') }}" class="menu-item {{ request()->routeIs('freelancer.projects.*') ? 'active' : '' }}">
                    <i class="bi bi-folder"></i>
                    <span>Active Projects</span>
                </a>
            </div>

            <!-- Services Section -->
            <div class="menu-section">
                <div class="menu-section-title">My Services</div>
                <a href="{{ route('freelancer.services.index') }}" class="menu-item {{ request()->routeIs('freelancer.services.index') || request()->routeIs('freelancer.services.edit') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i>
                    <span>My Gigs</span>
                </a>
                <a href="{{ route('freelancer.services.create') }}" class="menu-item {{ request()->routeIs('freelancer.services.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle"></i>
                    <span>Create New Gig</span>
                </a>
                <a href="{{ route('freelancer.service-orders') }}" class="menu-item {{ request()->routeIs('freelancer.service-orders*') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>Service Orders</span>
                </a>
            </div>

            <!-- Financial Section -->
            <div class="menu-section">
                <div class="menu-section-title">Financial</div>
                <a href="{{ route('freelancer.earnings') }}" class="menu-item {{ request()->routeIs('freelancer.earnings') ? 'active' : '' }}">
                    <i class="bi bi-currency-dollar"></i>
                    <span>My Earnings</span>
                </a>
                <a href="{{ route('freelancer.buy-bids') }}" class="menu-item {{ request()->routeIs('freelancer.buy-bids') ? 'active' : '' }}">
                    <i class="bi bi-bag-plus"></i>
                    <span>Buy Bids</span>
                </a>
                <a href="{{ route('freelancer.plans') }}" class="menu-item {{ request()->routeIs('freelancer.plans*') ? 'active' : '' }}">
                    <i class="bi bi-star"></i>
                    <span>Subscription Plans</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-credit-card"></i>
                    <span>Payouts</span>
                </a>
            </div>

            <!-- Communication Section -->
            <div class="menu-section">
                <div class="menu-section-title">Communication</div>
                <a href="{{ route('messages.index') }}" class="menu-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Messages</span>
                    <span class="menu-badge" id="messagesBadge" style="display: none;">0</span>
                </a>
                <a href="#" class="menu-item">
                    <i class="bi bi-bell"></i>
                    <span>Notifications</span>
                </a>
            </div>

            <!-- Account Section -->
            <div class="menu-section">
                <div class="menu-section-title">Account</div>
                <a href="{{ route('freelancer.profile') }}" class="menu-item {{ request()->routeIs('freelancer.profile') ? 'active' : '' }}">
                    <i class="bi bi-person"></i>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </div>

            <!-- Logout -->
            <div class="menu-logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="menu-item" style="width: 100%; border: none; background: none;">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Bar -->
        <header class="top-bar">
            <div class="top-bar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="top-bar-right">
                <button class="top-bar-icon" id="themeToggle" title="Toggle Theme">
                    <i class="bi bi-moon"></i>
                </button>
                <button class="top-bar-icon" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                </button>
                <a href="{{ route('freelancer.profile') }}" class="user-menu">
                    <img src="{{ auth()->user()->getFirstMediaUrl('avatar', 'thumb') ?: asset('images/default-avatar.png') }}"
                         alt="Avatar">
                    <span class="user-menu-name">{{ auth()->user()->name }}</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
            </div>
        </header>

        <!-- Content -->
        <main class="content-wrapper">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        // Restore sidebar state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
        }

        // Mobile sidebar
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('collapsed');
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            const icon = themeToggle.querySelector('i');
            if (icon.classList.contains('bi-moon')) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            }
        });

        // Fetch unread message count
        function fetchUnreadCount() {
            fetch('{{ route("messages.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('messagesBadge');
                    const notificationBadge = document.getElementById('notificationBadge');

                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'block';
                        notificationBadge.textContent = data.count;
                        notificationBadge.style.display = 'block';
                    } else {
                        badge.style.display = 'none';
                        notificationBadge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error fetching unread count:', error));
        }

        // Fetch on page load
        fetchUnreadCount();

        // Poll every 30 seconds
        setInterval(fetchUnreadCount, 30000);

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
