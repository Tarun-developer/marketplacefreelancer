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
      @vite(['resources/css/app.css', 'resources/js/app.js'])
      <script src="https://unpkg.com/dropzone@6/dist/min/dropzone.min.js"></script>
      <script src="https://unpkg.com/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
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
    </style>
</head>
<body>
     @include('partials.header')

     <div class="d-flex">
         <!-- Sidebar -->
         <nav id="sidebar" class="sidebar bg-dark text-white vh-100 position-fixed">
             <div class="p-3 border-bottom border-secondary">
                 <div class="d-flex justify-content-between align-items-center">
                     <h5 class="mb-0" id="sidebar-title">Admin Panel</h5>
                     <button class="btn btn-outline-light btn-sm" id="sidebar-toggle">
                         <i class="bi bi-chevron-left"></i>
                     </button>
                 </div>
             </div>
             <div class="p-2">
                 <ul class="nav flex-column">
                     <li class="nav-item">
                         <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-secondary' : '' }}">
                             <i class="bi bi-speedometer2 me-2"></i><span>Dashboard</span>
                         </a>
                     </li>
                     @php
                         $userRole = auth()->user()->getRoleNames()->first();
                     @endphp
                     @if(in_array($userRole, ['super_admin', 'admin', 'manager']))
                         <!-- Marketplace Management -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-2">MARKETPLACE</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.products.index') }}" class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-box-seam me-2"></i><span>Products</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.categories.index') }}" class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-tags me-2"></i><span>Categories</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.services.index') }}" class="nav-link text-white {{ request()->routeIs('admin.services.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-tools me-2"></i><span>Services</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.jobs.index') }}" class="nav-link text-white {{ request()->routeIs('admin.jobs.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-briefcase me-2"></i><span>Jobs</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.orders.index') }}" class="nav-link text-white {{ request()->routeIs('admin.orders.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-cart3 me-2"></i><span>Orders</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.transactions.index') }}" class="nav-link text-white {{ request()->routeIs('admin.transactions.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-currency-dollar me-2"></i><span>Transactions</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.reviews.index') }}" class="nav-link text-white {{ request()->routeIs('admin.reviews.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-star me-2"></i><span>Reviews</span>
                             </a>
                         </li>
                         <!-- Admin Management -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-3">ADMIN</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.users.index') }}" class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-people me-2"></i><span>Users</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.disputes.index') }}" class="nav-link text-white {{ request()->routeIs('admin.disputes.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-exclamation-triangle me-2"></i><span>Disputes</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.tickets.index') }}" class="nav-link text-white {{ request()->routeIs('admin.tickets.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-ticket me-2"></i><span>Support Tickets</span>
                             </a>
                         </li>
                          <li class="nav-item">
                              <a href="{{ route('admin.subscriptions.index') }}" class="nav-link text-white {{ request()->routeIs('admin.subscriptions.*', 'admin.subscription-plans.*') ? 'active bg-secondary' : '' }}">
                                  <i class="bi bi-card-checklist me-2"></i><span>Subscriptions</span>
                              </a>
                          </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.payment-gateways.index') }}" class="nav-link text-white {{ request()->routeIs('admin.payment-gateways.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-credit-card-2-front me-2"></i><span>Payment Gateways</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('admin.settings.index') }}" class="nav-link text-white {{ request()->routeIs('admin.settings.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-gear me-2"></i><span>Settings</span>
                             </a>
                         </li>
                         <!-- Communication -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-3">COMMUNICATION</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('messages.index') }}" class="nav-link text-white {{ request()->routeIs('messages.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-chat-dots me-2"></i><span>Messages</span>
                                 <span class="badge bg-danger ms-auto" id="messagesBadge" style="display: none;">0</span>
                             </a>
                         </li>
                     @elseif($userRole === 'freelancer')
                         <!-- Freelancer Section -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-2">FREELANCER</div>
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
                     @elseif($userRole === 'vendor')
                         <!-- Vendor Section -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-2">VENDOR</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('vendor.products.index') }}" class="nav-link text-white {{ request()->routeIs('vendor.products.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-box-seam me-2"></i><span>Products</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('vendor.orders.index') }}" class="nav-link text-white {{ request()->routeIs('vendor.orders.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-cart3 me-2"></i><span>Orders</span>
                             </a>
                         </li>
                     @elseif($userRole === 'client')
                         <!-- Client Section -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-2">CLIENT</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('client.jobs.index') }}" class="nav-link text-white {{ request()->routeIs('client.jobs.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-briefcase me-2"></i><span>Jobs</span>
                             </a>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('client.orders.index') }}" class="nav-link text-white {{ request()->routeIs('client.orders.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-cart3 me-2"></i><span>Orders</span>
                             </a>
                         </li>
                     @elseif($userRole === 'support')
                         <!-- Support Section -->
                         <li class="nav-item">
                             <div class="nav-link text-white-50 fw-bold small mt-2">SUPPORT</div>
                         </li>
                         <li class="nav-item">
                             <a href="{{ route('support.tickets.index') }}" class="nav-link text-white {{ request()->routeIs('support.tickets.*') ? 'active bg-secondary' : '' }}">
                                 <i class="bi bi-ticket me-2"></i><span>Tickets</span>
                             </a>
                         </li>
                     @endif
                 </ul>
             </div>
         </nav>

         <!-- Main Content -->
         <div id="main-content" class="main-content flex-fill">
             <!-- Top Bar -->
             <header class="bg-white shadow-sm p-3">
                 <div class="d-flex justify-content-between align-items-center">
                     <div class="d-flex align-items-center">
                         <button class="btn btn-outline-secondary me-3 d-md-none" id="mobile-sidebar-toggle">
                             <i class="bi bi-list"></i>
                         </button>
                         <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                     </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary me-2" id="theme-toggle">🌙</button>
                        <span class="me-2 text-muted">{{ auth()->user()->name }}</span>
                        <span class="badge bg-primary">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</span>
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
            this.textContent = document.body.classList.contains('theme-dark') ? '☀️' : '🌙';
        });

        // Messages badge polling
        async function updateMessagesBadge() {
            try {
                const response = await fetch('{{ route('messages.unread-count') }}');
                const data = await response.json();
                const badge = document.getElementById('messagesBadge');

                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-block';
                } else {
                    badge.style.display = 'none';
                }
            } catch (error) {
                console.error('Failed to fetch unread messages count:', error);
            }
        }

        // Update badge on page load
        updateMessagesBadge();

        // Poll every 10 seconds
        setInterval(updateMessagesBadge, 10000);
    </script>
</body>
</html>
