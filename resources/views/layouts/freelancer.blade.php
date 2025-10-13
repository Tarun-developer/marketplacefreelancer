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

    <div class="menu-section-title mt-4">Finance</div>
    <a href="{{ route('freelancer.earnings') }}" class="menu-item">
        <i class="bi bi-currency-dollar"></i>
        <span>Earnings</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-credit-card"></i>
        <span>Payouts</span>
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
