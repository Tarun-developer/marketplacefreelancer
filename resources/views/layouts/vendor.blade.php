@extends('layouts.dashboard')

@section('sidebar-menu')
    <div class="menu-section-title">Main</div>
    <a href="{{ route('vendor.dashboard') }}" class="menu-item {{ request()->routeIs('vendor.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <div class="menu-section-title mt-4">Products</div>
    <a href="{{ route('vendor.products.index') }}" class="menu-item {{ request()->routeIs('vendor.products.index') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>All Products</span>
    </a>
    <a href="{{ route('vendor.products.create') }}" class="menu-item {{ request()->routeIs('vendor.products.create') ? 'active' : '' }}">
        <i class="bi bi-plus-circle"></i>
        <span>Add Product</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-grid"></i>
        <span>Categories</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-tags"></i>
        <span>Collections</span>
    </a>

    <div class="menu-section-title mt-4">Sales</div>
    <a href="{{ route('vendor.orders.index') }}" class="menu-item {{ request()->routeIs('vendor.orders.*') ? 'active' : '' }}">
        <i class="bi bi-cart-check"></i>
        <span>Orders</span>
        @if(auth()->user()->ordersAsSeller()->where('status', 'pending')->count() > 0)
            <span class="menu-badge">{{ auth()->user()->ordersAsSeller()->where('status', 'pending')->count() }}</span>
        @endif
    </a>
    <a href="{{ route('vendor.analytics') }}" class="menu-item {{ request()->routeIs('vendor.analytics') ? 'active' : '' }}">
        <i class="bi bi-graph-up"></i>
        <span>Analytics</span>
    </a>
    <a href="#" class="menu-item">
        <i class="bi bi-star"></i>
        <span>Reviews</span>
    </a>

    <div class="menu-section-title mt-4">Finance</div>
    <a href="{{ route('vendor.earnings') }}" class="menu-item {{ request()->routeIs('vendor.earnings') ? 'active' : '' }}">
        <i class="bi bi-currency-dollar"></i>
        <span>Earnings</span>
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
     <a href="{{ route('profile.edit') }}" class="menu-item">
         <i class="bi bi-shop"></i>
         <span>Store Settings</span>
     </a>
     <a href="{{ route('vendor.documentation') }}" class="menu-item">
         <i class="bi bi-book"></i>
         <span>License Docs</span>
     </a>
     <a href="{{ route('profile.edit') }}" class="menu-item">
         <i class="bi bi-gear"></i>
         <span>Settings</span>
     </a>
@endsection
