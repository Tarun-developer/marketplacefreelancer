@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    <p class="text-sm text-green-600 mt-2">+{{ $stats['new_users_this_month'] }} this month</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-sm text-green-600 mt-2">${{ number_format($stats['revenue_this_month'], 2) }} this month</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Orders -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Active Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['active_orders'] }}</p>
                    <p class="text-sm text-blue-600 mt-2">{{ $stats['completed_orders'] }} completed</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Disputes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 font-medium">Pending Disputes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_disputes'] }}</p>
                    <p class="text-sm text-red-600 mt-2">{{ $stats['resolved_disputes'] }} resolved</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-600 font-medium">Total Products</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stats['pending_products'] }} pending approval</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-600 font-medium">Active Services</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_services'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stats['total_services'] }} total</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-600 font-medium">Open Jobs</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['open_jobs'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stats['total_bids'] }} total bids</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-600 font-medium">Support Tickets</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['open_tickets'] }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $stats['total_tickets'] }} total</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recent_orders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-600">{{ $order->buyer->name }} - ${{ number_format($order->amount, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                @if($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent orders</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.orders.index') }}"
                       class="block text-center text-indigo-600 hover:text-indigo-700 font-medium">
                        View All Orders →
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Recent Users</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recent_users as $user)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-500">Joined {{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                {{ ucfirst($user->getRoleNames()->first() ?? 'User') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent users</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('users.index') }}"
                       class="block text-center text-indigo-600 hover:text-indigo-700 font-medium">
                        View All Users →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('users.create') }}"
                       class="flex items-center justify-center px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add User
                    </a>
                    <a href="{{ route('products.create') }}"
                       class="flex items-center justify-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Product
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                       class="flex items-center justify-center px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        View Orders
                    </a>
                    <a href="{{ route('settings.index') }}"
                       class="flex items-center justify-center px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">System Status</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Database</span>
                        <span class="flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                            Connected
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Cache</span>
                        <span class="flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                            Active
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Queue</span>
                        <span class="flex items-center text-green-600">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                            Running
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Storage</span>
                        <span class="text-gray-600">{{ $stats['storage_used'] }} / 100 GB</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">Last Backup</span>
                        <span class="text-gray-600">2 hours ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
