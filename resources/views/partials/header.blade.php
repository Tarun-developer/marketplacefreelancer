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
                    <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none me-4">Dashboard</a>
                    @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                        <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none me-4">Admin</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-muted text-decoration-none me-4">Login</a>
                    <a href="{{ route('register') }}" class="text-muted text-decoration-none">Sign Up</a>
                @endauth
            </nav>

            <!-- User Menu & Mobile Menu Button -->
             <div class="d-flex align-items-center">
                 @auth
                     <!-- Role Switcher -->
                     @php
                         $userRoles = auth()->user()->roles->pluck('name')->toArray();
                         $allRoles = ['client', 'freelancer', 'vendor'];
                         $currentRole = auth()->user()->current_role;
                     @endphp

                     @if(count($userRoles) > 0)
                         <div class="dropdown me-3">
                             <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                 <i class="bi bi-diagram-3 me-2"></i>{{ ucfirst($currentRole ?? 'Select Role') }}
                             </button>
                             <ul class="dropdown-menu">
                                 @foreach($allRoles as $role)
                                     @if(in_array($role, $userRoles))
                                         <li>
                                             <a class="dropdown-item switch-role" href="#" data-role="{{ $role }}">
                                                 <i class="bi bi-{{ $role === 'client' ? 'person-check' : ($role === 'freelancer' ? 'tools' : 'shop') }} me-2"></i>
                                                 Switch to {{ ucfirst($role) }}
                                             </a>
                                         </li>
                                     @else
                                         <li>
                                             <a class="dropdown-item become-role" href="#" data-role="{{ $role }}">
                                                 <i class="bi bi-plus-circle me-2"></i>
                                                 Become {{ ucfirst($role) }}
                                             </a>
                                         </li>
                                     @endif
                                 @endforeach
                             </ul>
                         </div>
                     @endif

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

                 <!-- Role Switcher Script -->
                 @auth
                     @if(count($userRoles ?? []) > 0)
                         <script>
                             document.querySelectorAll('.switch-role, .become-role').forEach(link => {
                                 link.addEventListener('click', function(e) {
                                     e.preventDefault();
                                     const role = this.getAttribute('data-role');
                                     const isBecome = this.classList.contains('become-role');
                                     const action = isBecome ? 'become' : 'switch to';

                                     if (confirm(`Are you sure you want to ${action} ${role} role?`)) {
                                         fetch('{{ route("switch-role") }}', {
                                             method: 'POST',
                                             headers: {
                                                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                 'Content-Type': 'application/json',
                                             },
                                             body: JSON.stringify({ role: role })
                                         })
                                         .then(response => response.json())
                                         .then(data => {
                                             if (data.success) {
                                                 window.location.href = data.redirect;
                                             } else {
                                                 alert('Error: ' + (data.error || 'Please try again.'));
                                             }
                                         })
                                         .catch(error => {
                                             alert('Error. Please try again.');
                                         });
                                     }
                                 });
                             });
                         </script>
                     @endif
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