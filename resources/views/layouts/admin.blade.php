<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - MarketFusion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --royal-purple: #6B46C1;
            --royal-blue: #4C51BF;
            --deep-purple: #553C9A;
            --gold: #F6AD55;
            --light-gold: #FBD38D;
            --dark-bg: #1A202C;
            --sidebar-bg: linear-gradient(180deg, #2D3748 0%, #1A202C 100%);
            --accent-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-green: #48BB78;
            --danger-red: #F56565;
            --text-light: #E2E8F0;
            --text-muted: #A0AEC0;
        }

        body {
            background: #F7FAFC;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            box-shadow: 4px 0 20px rgba(107, 70, 193, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(107, 70, 193, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .menu-item-text,
        .sidebar.collapsed .section-title {
            display: none;
        }

        /* Menu Styles */
        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .section-title {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.875rem 1.5rem;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s;
            position: relative;
            margin: 0.25rem 0.75rem;
            border-radius: 12px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: var(--gold);
            transform: translateX(4px);
        }

        .menu-item.active {
            background: var(--accent-gradient);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: var(--gold);
            border-radius: 0 4px 4px 0;
        }

        .menu-item i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .menu-badge {
            margin-left: auto;
            padding: 0.25rem 0.625rem;
            background: var(--danger-red);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-bar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2D3748;
            margin: 0;
        }

        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: #F7FAFC;
            color: #4A5568;
            transition: all 0.3s;
        }

        .btn-icon:hover {
            background: var(--accent-gradient);
            color: white;
            transform: translateY(-2px);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.5rem 1rem;
            background: #F7FAFC;
            border-radius: 12px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .user-profile:hover {
            background: #EDF2F7;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #2D3748;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .dropdown-menu {
            border-radius: 12px;
            padding: 0.5rem;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.625rem 1rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: var(--accent-gradient);
            color: white;
        }

        .dropdown-item i {
            width: 20px;
        }

        .btn-icon.position-relative .badge {
            font-size: 0.65rem;
            padding: 0.25em 0.5em;
        }

        .btn-icon:not(button) {
            text-decoration: none;
        }

        .role-badge {
            padding: 0.25rem 0.75rem;
            background: var(--accent-gradient);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
            text-transform: capitalize;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Toggle Button */
        .sidebar-toggle {
            position: absolute;
            right: -15px;
            top: 70px;
            width: 30px;
            height: 30px;
            background: var(--accent-gradient);
            border: 3px solid #F7FAFC;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .user-info {
                display: none;
            }
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #48BB78 0%, #38A169 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #F56565 0%, #E53E3E 100%);
            color: white;
        }

        /* Animations */
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .menu-item {
            animation: slideInRight 0.3s ease-out;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div class="brand-icon">
                    <i class="bi bi-gem"></i>
                </div>
                <span class="brand-text">MarketFusion</span>
            </a>
            <div class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-chevron-left" id="toggleIcon"></i>
            </div>
        </div>

        <nav class="sidebar-menu">
            @php
                $userRole = auth()->user()->getRoleNames()->first();
            @endphp

            @if(in_array($userRole, ['super_admin', 'admin']))
                <!-- Overview Section -->
                <div class="menu-section">
                    <div class="section-title">
                        <i class="bi bi-grid"></i>
                        <span>Overview</span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i>
                        <span class="menu-item-text">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="menu-item-text">Users</span>
                    </a>
                </div>

                <!-- Marketplace Section -->
                <div class="menu-section">
                    <div class="section-title">
                        <i class="bi bi-shop"></i>
                        <span>Marketplace</span>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span class="menu-item-text">Products</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="menu-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                        <i class="bi bi-tools"></i>
                        <span class="menu-item-text">Services</span>
                    </a>
                    <a href="{{ route('admin.jobs.index') }}" class="menu-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                        <i class="bi bi-briefcase"></i>
                        <span class="menu-item-text">Jobs</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tag"></i>
                        <span class="menu-item-text">Categories</span>
                    </a>
                </div>

                <!-- Financial Section -->
                <div class="menu-section">
                    <div class="section-title">
                        <i class="bi bi-cash-stack"></i>
                        <span>Financial</span>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i>
                        <span class="menu-item-text">Orders</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" class="menu-item {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card"></i>
                        <span class="menu-item-text">Transactions</span>
                    </a>
                    <a href="{{ route('admin.payment-gateways.index') }}" class="menu-item {{ request()->routeIs('admin.payment-gateways.*') ? 'active' : '' }}">
                        <i class="bi bi-wallet2"></i>
                        <span class="menu-item-text">Payment Gateways</span>
                    </a>
                    <a href="{{ route('admin.subscriptions.index') }}" class="menu-item {{ request()->routeIs('admin.subscriptions.*', 'admin.subscription-plans.*') ? 'active' : '' }}">
                        <i class="bi bi-card-checklist"></i>
                        <span class="menu-item-text">Subscriptions</span>
                    </a>
                </div>

                <!-- Support Section -->
                <div class="menu-section">
                    <div class="section-title">
                        <i class="bi bi-headset"></i>
                        <span>Support</span>
                    </div>
                    <a href="{{ route('admin.tickets.index') }}" class="menu-item {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                        <i class="bi bi-ticket-perforated"></i>
                        <span class="menu-item-text">Support Tickets</span>
                    </a>
                    <a href="{{ route('admin.disputes.index') }}" class="menu-item {{ request()->routeIs('admin.disputes.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span class="menu-item-text">Disputes</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <i class="bi bi-star"></i>
                        <span class="menu-item-text">Reviews</span>
                    </a>
                    <a href="{{ route('messages.index') }}" class="menu-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-dots"></i>
                        <span class="menu-item-text">Messages</span>
                        <span class="menu-badge" id="messagesBadge" style="display: none;">0</span>
                    </a>
                </div>

                <!-- Settings Section -->
                <div class="menu-section">
                    <div class="section-title">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </div>
                    <a href="{{ route('admin.settings.index') }}" class="menu-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="bi bi-sliders"></i>
                        <span class="menu-item-text">General Settings</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="menu-item">
                        <i class="bi bi-person-circle"></i>
                        <span class="menu-item-text">My Profile</span>
                    </a>
                </div>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <div id="mainContent" class="main-content">
        <!-- Top Bar -->
        <header class="top-bar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn-icon d-md-none" id="mobileSidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="top-bar-title">@yield('page-title', 'Dashboard')</h1>
            </div>
             <div class="top-bar-actions">
                 @include('partials.role-switcher')
                 <button class="btn-icon d-md-none" id="mobileSidebarToggle">
                     <i class="bi bi-list"></i>
                 </button>
                <a href="{{ route('messages.index') }}" class="btn-icon position-relative" title="Messages">
                    <i class="bi bi-chat-dots"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="topMessagesBadge" style="display: none;">0</span>
                </a>
                <button class="btn-icon position-relative" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationsBadge" style="display: none;">0</span>
                </button>
                <div class="dropdown">
                    <div class="user-profile" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</div>
                        </div>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="min-width: 200px;">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>My Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

     <!-- Bootstrap JS -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



     <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleIcon = document.getElementById('toggleIcon');
        const sidebarToggle = document.getElementById('sidebarToggle');

        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');

            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('bi-chevron-left');
                toggleIcon.classList.add('bi-chevron-right');
            } else {
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-left');
            }
        });

        // Mobile Sidebar Toggle
        document.getElementById('mobileSidebarToggle').addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !event.target.closest('#mobileSidebarToggle')) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Theme Toggle (placeholder)
        document.getElementById('themeToggle').addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon.classList.contains('bi-moon')) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            }
        });

        // Messages Badge Polling
        async function updateMessagesBadge() {
            try {
                const response = await fetch('{{ route('messages.unread-count') }}');
                const data = await response.json();
                const sidebarBadge = document.getElementById('messagesBadge');
                const topBadge = document.getElementById('topMessagesBadge');

                if (data.count > 0) {
                    if (sidebarBadge) {
                        sidebarBadge.textContent = data.count;
                        sidebarBadge.style.display = 'inline-block';
                    }
                    if (topBadge) {
                        topBadge.textContent = data.count;
                        topBadge.style.display = 'inline-block';
                    }
                } else {
                    if (sidebarBadge) sidebarBadge.style.display = 'none';
                    if (topBadge) topBadge.style.display = 'none';
                }
            } catch (error) {
                console.error('Failed to fetch unread messages count:', error);
            }
        }

        // Update badge on page load and poll every 10 seconds
        updateMessagesBadge();
        setInterval(updateMessagesBadge, 10000);
     </script>
 </body>
 </html>

 @include('chat.widget')
