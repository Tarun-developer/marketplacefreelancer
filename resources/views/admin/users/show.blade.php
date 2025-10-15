@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="container-fluid">
    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="{{ $user->getFirstMediaUrl('avatar', 'medium') ?: asset('images/default-avatar.png') }}"
                                 alt="Avatar" class="rounded-circle img-fluid">
                        </div>
                        <div class="col-md-10">
                            <h3>{{ $user->name }}</h3>
                            <p class="text-muted">{{ $user->email }}</p>
                            <div class="mb-3">
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary me-2">{{ $role->name }}</span>
                                @endforeach
                                <span class="badge @if($user->is_active) bg-success @else bg-danger @endif ms-2">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>

                            </div>
                            <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y \a\t g:i A') }}</p>
                            <p><strong>Last Login:</strong> {{ $user->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Orders</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">Products</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">Services</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wallet-tab" data-bs-toggle="tab" data-bs-target="#wallet" type="button" role="tab">Wallet</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- Profile Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel">
                            @if($user->profile)
                                <h5>Profile Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Title:</strong> {{ $user->profile->title ?? 'N/A' }}</p>
                                        <p><strong>Bio:</strong> {{ $user->profile->bio ?? 'N/A' }}</p>
                                        <p><strong>Location:</strong> {{ $user->profile->location ?? 'N/A' }}</p>
                                        <p><strong>Skills:</strong> {{ $user->profile->skills ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Hourly Rate:</strong> ${{ $user->profile->hourly_rate ?? 'N/A' }}</p>
                                        <p><strong>Portfolio URL:</strong> {{ $user->profile->portfolio_url ?? 'N/A' }}</p>
                                        <p><strong>LinkedIn:</strong> {{ $user->profile->linkedin_url ?? 'N/A' }}</p>
                                        <p><strong>GitHub:</strong> {{ $user->profile->github_url ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">No profile information available.</p>
                            @endif

                            @if($user->kyc)
                                <h5 class="mt-4">KYC Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong>
                                            <span class="badge @if($user->kyc->status === 'approved') bg-success @elseif($user->kyc->status === 'pending') bg-warning @else bg-danger @endif">
                                                {{ ucfirst($user->kyc->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Document Type:</strong> {{ $user->kyc->document_type ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Submitted:</strong> {{ $user->kyc->created_at->format('M d, Y') }}</p>
                                        @if($user->kyc->approved_at)
                                            <p><strong>Approved:</strong> {{ $user->kyc->approved_at->format('M d, Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">No KYC information available.</p>
                            @endif
                        </div>

                        <!-- Orders Tab -->
                        <div class="tab-pane fade" id="orders" role="tabpanel">
                            <h5>Orders ({{ $user->orders->count() }})</h5>
                            @if($user->orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->orders->take(10) as $order)
                                                <tr>
                                                    <td>#{{ $order->id }}</td>
                                                    <td>{{ ucfirst($order->orderable_type ?? 'N/A') }}</td>
                                                    <td>${{ number_format($order->amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge @if($order->status === 'completed') bg-success @elseif($order->status === 'pending') bg-warning @else bg-danger @endif">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($user->orders->count() > 10)
                                    <a href="{{ route('admin.orders.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">View All Orders</a>
                                @endif
                            @else
                                <p class="text-muted">No orders found.</p>
                            @endif
                        </div>

                        <!-- Products Tab -->
                        <div class="tab-pane fade" id="products" role="tabpanel">
                            <h5>Products ({{ $user->products->count() }})</h5>
                            @if($user->products->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Sales</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->products->take(10) as $product)
                                                <tr>
                                                    <td>{{ Str::limit($product->name, 30) }}</td>
                                                    <td>${{ number_format($product->price, 2) }}</td>
                                                    <td>
                                                        <span class="badge @if($product->status === 'active') bg-success @else bg-warning @endif">
                                                            {{ ucfirst($product->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $product->orders->count() }}</td>
                                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($user->products->count() > 10)
                                    <a href="{{ route('admin.products.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">View All Products</a>
                                @endif
                            @else
                                <p class="text-muted">No products found.</p>
                            @endif
                        </div>

                        <!-- Services Tab -->
                        <div class="tab-pane fade" id="services" role="tabpanel">
                            <h5>Services ({{ $user->services->count() }})</h5>
                            @if($user->services->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Delivery</th>
                                                <th>Status</th>
                                                <th>Orders</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->services->take(10) as $service)
                                                <tr>
                                                    <td>{{ Str::limit($service->title, 30) }}</td>
                                                    <td>${{ number_format($service->price, 2) }}</td>
                                                    <td>{{ $service->delivery_time }} days</td>
                                                    <td>
                                                        <span class="badge @if($service->status === 'active') bg-success @else bg-warning @endif">
                                                            {{ ucfirst($service->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $service->orders->count() }}</td>
                                                    <td>{{ $service->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($user->services->count() > 10)
                                    <a href="{{ route('admin.services.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">View All Services</a>
                                @endif
                            @else
                                <p class="text-muted">No services found.</p>
                            @endif
                        </div>

                        <!-- Wallet Tab -->
                        <div class="tab-pane fade" id="wallet" role="tabpanel">
                            <h5>Wallet Information</h5>
                            @if($user->wallet)
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Balance:</strong> ${{ number_format($user->wallet->balance, 2) }}</p>
                                        <p><strong>Currency:</strong> {{ $user->wallet->currency ?? 'USD' }}</p>
                                        <p><strong>Status:</strong>
                                            <span class="badge @if($user->wallet->is_active) bg-success @else bg-danger @endif">
                                                {{ $user->wallet->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Earned:</strong> ${{ number_format($user->wallet->total_earned, 2) }}</p>
                                        <p><strong>Total Spent:</strong> ${{ number_format($user->wallet->total_spent, 2) }}</p>
                                        <p><strong>Created:</strong> {{ $user->wallet->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>

                                <h6 class="mt-4">Recent Transactions</h6>
                                @if($user->walletTransactions->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>Description</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->walletTransactions->take(5) as $transaction)
                                                    <tr>
                                                        <td>{{ ucfirst($transaction->type) }}</td>
                                                        <td class="@if($transaction->type === 'credit') text-success @else text-danger @endif">
                                                            ${{ number_format($transaction->amount, 2) }}
                                                        </td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route('admin.transactions.index', ['user' => $user->id]) }}" class="btn btn-outline-primary">View All Transactions</a>
                                @else
                                    <p class="text-muted">No transactions found.</p>
                                @endif
                            @else
                                <p class="text-muted">No wallet found for this user.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit User</a>
                    @if($user->is_active)
                        <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to suspend this user?')">
                                Suspend User
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">Activate User</button>
                        </form>
                    @endif
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to Users</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection