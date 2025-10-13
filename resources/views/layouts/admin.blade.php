<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - MarketFusion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('partials.header')

    <div class="flex min-h-screen" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
               class="bg-gray-900 text-white transition-all duration-300 flex-shrink-0">
            <div class="p-4 flex justify-between items-center border-b border-gray-800">
                <h2 x-show="sidebarOpen" class="text-xl font-bold">Admin Panel</h2>
                <button @click="sidebarOpen = !sidebarOpen"
                        class="p-2 hover:bg-gray-800 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <nav class="mt-4 px-2">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('dashboard') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </a>

                <!-- Users -->
                <a href="{{ route('users.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('users.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Users</span>
                </a>

                <!-- Products -->
                <a href="{{ route('products.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('products.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Products</span>
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('categories.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Categories</span>
                </a>

                <!-- Services -->
                <a href="{{ route('admin.services.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.services.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Services</span>
                </a>

                <!-- Jobs -->
                <a href="{{ route('admin.jobs.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.jobs.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Jobs</span>
                </a>

                <!-- Orders -->
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Orders</span>
                </a>

                <!-- Transactions -->
                <a href="{{ route('admin.transactions.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Transactions</span>
                </a>

                <!-- Disputes -->
                <a href="{{ route('admin.disputes.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.disputes.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Disputes</span>
                </a>

                <!-- Support Tickets -->
                <a href="{{ route('admin.tickets.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.tickets.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Support Tickets</span>
                </a>

                <!-- Reviews -->
                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Reviews</span>
                </a>

                <!-- Subscriptions -->
                <a href="{{ route('admin.subscriptions.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('admin.subscriptions.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Subscriptions</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('settings.index') }}"
                   class="flex items-center py-3 px-4 mb-1 rounded-lg hover:bg-gray-800 {{ request()->routeIs('settings.*') ? 'bg-gray-800' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm px-6 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                            {{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-6 overflow-y-auto">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
