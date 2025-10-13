<!-- Header -->
<header class="bg-white shadow-sm border-bottom">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg">
            <div class="d-flex justify-content-between align-items-center py-3 w-100">
            <!-- Logo -->
            <div class="d-flex align-items-center">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <span class="fw-bold">M</span>
                    </div>
                    <span class="ms-2 fw-bold text-dark fs-5">MarketFusion</span>
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <nav class="d-none d-md-flex align-items-center">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none me-4">Home</a>
                @auth
                    <a href="{{ route('dashboard') }}?view=all" class="text-muted text-decoration-none me-4">User Dashboard</a>
                     @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                         <a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none me-4">Admin Dashboard</a>
                     @endif
                @else
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none me-4">Login</a>
                    <a href="{{ route('register') }}" class="text-muted text-decoration-none">Sign Up</a>
                @endauth
            </nav>

            <!-- User Menu & Mobile Menu Button -->
             <div class="d-flex align-items-center">
                 @auth
                     <!-- User Dropdown -->
                     <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                <span class="fw-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                             <li>
                                 <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                     @csrf
                                     <button type="submit" class="dropdown-item">Logout</button>
                                 </form>
                             </li>
                         </ul>
                     </div>
                 @endauth

                 <!-- Mobile menu button -->
                 <button class="btn btn-outline-secondary d-md-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-menu">
                     <i class="bi bi-list"></i>
                 </button>
             </div>

             <!-- Mobile menu (Collapsible) -->
             <div class="collapse d-md-none mt-2" id="mobile-menu">
                 <nav class="bg-light p-3 rounded">
                     <a href="{{ url('/') }}" class="d-block text-muted text-decoration-none py-2">Home</a>
                     @auth
                         <a href="{{ route('dashboard') }}" class="d-block text-muted text-decoration-none py-2">Dashboard</a>
                         @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                             <a href="{{ route('admin.users.index') }}" class="d-block text-muted text-decoration-none py-2">Admin</a>
                         @endif
                     @else
                         <a href="{{ route('login') }}" class="d-block text-muted text-decoration-none py-2">Login</a>
                         <a href="{{ route('register') }}" class="d-block text-muted text-decoration-none py-2">Sign Up</a>
                     @endauth
                 </nav>
             </div>
         </nav>
    </header>
