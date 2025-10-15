@extends('layouts.client')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">My Profile</h1>
            </div>

            <div class="row">
                <!-- Current Plan -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-star me-2 text-primary"></i>Current Plan
                            </h5>

                            @if($activeSubscription)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-crown fa-lg"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-1">{{ $activeSubscription->plan->name }}</h4>
                                        <p class="text-muted mb-0">${{ number_format($activeSubscription->plan->price, 2) }} / {{ $activeSubscription->plan->billing_period }}</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <span><i class="fas fa-project-diagram me-2"></i>Project Limit:</span>
                                            <strong>{{ $activeSubscription->plan->max_projects ?? 'Unlimited' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <span><i class="fas fa-shield-alt me-2"></i>Escrow:</span>
                                            <strong>{{ $activeSubscription->plan->escrow_enabled ? 'Enabled' : 'Disabled' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <span><i class="fas fa-credit-card me-2"></i>Advance Payment:</span>
                                            <strong>{{ $activeSubscription->plan->advance_payment_required ? 'Required' : 'Optional' }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                            <span><i class="fas fa-check-circle me-2"></i>Verification:</span>
                                            <strong>{{ $activeSubscription->plan->verified_required ? 'Required' : 'Optional' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <small class="text-muted">Expires: {{ $activeSubscription->ends_at->format('M d, Y') }}</small>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-info-circle text-muted fa-3x mb-3"></i>
                                    <h5>No Active Plan</h5>
                                    <p class="text-muted">You are currently on the free plan. Upgrade to unlock more features.</p>
                                    <a href="{{ route('client.plans') }}" class="btn btn-primary">View Plans</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Usage Stats -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>Usage Statistics
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-briefcase me-2"></i>Projects Posted:</span>
                                        <strong>{{ auth()->user()->jobs()->count() }} / {{ auth()->user()->getProjectLimit() }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-shopping-cart me-2"></i>Active Orders:</span>
                                        <strong>{{ auth()->user()->ordersAsBuyer()->whereIn('status', ['pending', 'processing'])->count() }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-dollar-sign me-2"></i>Total Spent:</span>
                                        <strong>${{ number_format(auth()->user()->ordersAsBuyer()->where('status', 'completed')->sum('amount'), 2) }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-star me-2"></i>Completed Orders:</span>
                                        <strong>{{ auth()->user()->ordersAsBuyer()->where('status', 'completed')->count() }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Available Plans -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-list me-2 text-primary"></i>Available Plans
                            </h5>

                            @foreach($plans as $plan)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $plan->name }}</strong>
                                        <br>
                                        <small class="text-muted">${{ number_format($plan->price, 2) }} / {{ $plan->billing_period }}</small>
                                    </div>
                                    @if($activeSubscription && $activeSubscription->subscription_plan_id === $plan->id)
                                        <span class="badge bg-success">Current</span>
                                    @else
                                        <a href="{{ route('client.show-plan-checkout', $plan->id) }}" class="btn btn-sm btn-outline-primary">Upgrade</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                            </h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Post New Job
                                </a>
                                <a href="{{ route('client.services.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-search me-2"></i>Browse Services
                                </a>
                                <a href="{{ route('client.orders.index') }}" class="btn btn-outline-info">
                                    <i class="fas fa-list me-2"></i>My Orders
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection