@extends('layouts.dashboard')

@section('sidebar-menu')
    <div class="menu-section-title">Main</div>
    <a href="{{ route('client.dashboard') }}" class="menu-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <div class="menu-section-title mt-4">Projects</div>
    <a href="{{ route('client.jobs.index') }}" class="menu-item {{ request()->routeIs('client.jobs.*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i>
        <span>My Jobs</span>
    </a>
    <a href="{{ route('client.jobs.create') }}" class="menu-item">
        <i class="bi bi-plus-circle"></i>
        <span>Post New Job</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-clock-history"></i>
        <span>Job History</span>
    </a>

    <div class="menu-section-title mt-4">Orders</div>
    <a href="{{ route('client.orders.index') }}" class="menu-item {{ request()->routeIs('client.orders.*') ? 'active' : '' }}">
        <i class="bi bi-cart"></i>
        <span>My Orders</span>
        @if(auth()->user()->ordersAsBuyer()->whereIn('status', ['pending', 'processing'])->count() > 0)
            <span class="menu-badge">{{ auth()->user()->ordersAsBuyer()->whereIn('status', ['pending', 'processing'])->count() }}</span>
        @endif
    </a>
     <a href="{{ route('client.favorites') }}" class="menu-item {{ request()->routeIs('client.favorites') ? 'active' : '' }}">
         <i class="bi bi-heart"></i>
         <span>Favorites</span>
     </a>

    <div class="menu-section-title mt-4">Finance</div>
     <a href="{{ route('client.wallet.index') }}" class="menu-item {{ request()->routeIs('client.wallet.*') ? 'active' : '' }}">
         <i class="bi bi-wallet2"></i>
         <span>Wallet</span>
     </a>
    <a href="#" class="menu-item">
        <i class="bi bi-receipt"></i>
        <span>Invoices</span>
    </a>

    <div class="menu-section-title mt-4">Communication</div>
     <a href="{{ route('messages.index') }}" class="menu-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
         <i class="bi bi-chat-dots"></i>
         <span>Messages</span>
         <span class="menu-badge" id="messagesBadge" style="display: none;">0</span>
     </a>

    <div class="menu-section-title mt-4">Account</div>
     <a href="{{ route('client.profile') }}" class="menu-item">
         <i class="bi bi-person"></i>
         <span>My Profile</span>
     </a>
    <a href="{{ route('profile.edit') }}" class="menu-item">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
    </a>
@endsection
