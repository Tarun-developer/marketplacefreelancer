@extends('layouts.dashboard')

@section('sidebar-menu')
    <div class="menu-section-title">Main</div>
    <a href="{{ route('freelancer.dashboard') }}" class="menu-item {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <div class="menu-section-title mt-4">Work</div>
    <a href="{{ route('freelancer.jobs.index') }}" class="menu-item {{ request()->routeIs('freelancer.jobs.*') ? 'active' : '' }}">
        <i class="bi bi-briefcase"></i>
        <span>Browse Jobs</span>
    </a>
    <a href="{{ route('freelancer.proposals.index') }}" class="menu-item {{ request()->routeIs('freelancer.proposals.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text"></i>
        <span>My Proposals</span>
        @if(auth()->user()->bids()->where('status', 'pending')->count() > 0)
            <span class="menu-badge">{{ auth()->user()->bids()->where('status', 'pending')->count() }}</span>
        @endif
    </a>
     <a href="{{ route('freelancer.services.index') }}" class="menu-item {{ request()->routeIs('freelancer.services.*') ? 'active' : '' }}">
         <i class="bi bi-tools"></i>
         <span>My Gigs</span>
     </a>
     <a href="{{ route('freelancer.service-orders') }}" class="menu-item {{ request()->routeIs('freelancer.service-orders*') ? 'active' : '' }}">
         <i class="bi bi-receipt"></i>
         <span>Service Orders</span>
     </a>
     <a href="{{ route('freelancer.projects.index') }}" class="menu-item {{ request()->routeIs('freelancer.projects.*') ? 'active' : '' }}">
         <i class="bi bi-folder"></i>
         <span>My Projects</span>
     </a>

    <div class="menu-section-title mt-4">Finance</div>
     <a href="{{ route('freelancer.earnings') }}" class="menu-item">
         <i class="bi bi-currency-dollar"></i>
         <span>Earnings</span>
     </a>
     <a href="{{ route('freelancer.buy-bids') }}" class="menu-item">
         <i class="bi bi-bag-plus"></i>
         <span>Buy Bids</span>
     </a>
     <a href="{{ route('freelancer.plans') }}" class="menu-item">
         <i class="bi bi-star"></i>
         <span>Upgrade Plan</span>
     </a>
     <a href="#" class="menu-item">
         <i class="bi bi-credit-card"></i>
         <span>Payouts</span>
     </a>

    <div class="menu-section-title mt-4">Communication</div>
     <a href="{{ route('messages.index') }}" class="menu-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
         <i class="bi bi-chat-dots"></i>
         <span>Messages</span>
         <span class="menu-badge" id="messagesBadge" style="display: none;">0</span>
     </a>

    <div class="menu-section-title mt-4">Account</div>
    <a href="{{ route('freelancer.profile') }}" class="menu-item">
        <i class="bi bi-person"></i>
        <span>My Profile</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="menu-item">
        <i class="bi bi-gear"></i>
        <span>Settings</span>
    </a>
@endsection
