<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">M</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">MarketFusion</span>
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">Dashboard</a>
                    @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                        <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">Users</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium transition-colors">Sign Up</a>
                @endauth
            </nav>

            <!-- User Menu & Mobile Menu Button -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600 focus:outline-none">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="hidden md:block text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-transition>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="hidden md:inline-flex items-center px-4 py-2 border border-indigo-600 text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 transition-colors">
                        Sign Up
                    </a>
                @endauth

                <!-- Mobile menu button -->
                <button type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ url('/') }}" class="text-gray-700 hover:text-indigo-600 block px-3 py-2 text-base font-medium">Home</a>
            @auth
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 block px-3 py-2 text-base font-medium">Dashboard</a>
                @if(auth()->user()->hasRole('SuperAdmin|Admin'))
                    <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-indigo-600 block px-3 py-2 text-base font-medium">Users</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 block px-3 py-2 text-base font-medium">Login</a>
                <a href="{{ route('register') }}" class="text-gray-700 hover:text-indigo-600 block px-3 py-2 text-base font-medium">Sign Up</a>
            @endauth
        </div>
    </div>
</header>