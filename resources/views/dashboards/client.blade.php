@extends('layouts.client')

@section('title', 'Client Dashboard')

@section('page-title', 'Client Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <h6 class="text-muted mb-2">Posted Jobs</h6>
                             <h3 class="mb-0 text-primary">{{ $stats['posted_jobs'] }} / {{ $stats['project_limit'] }}</h3>
                         </div>
                        <div class="text-primary" style="font-size: 2rem;">
                            <i class="bi bi-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Active Orders</h6>
                            <h3 class="mb-0 text-warning">{{ $stats['active_orders'] }}</h3>
                        </div>
                        <div class="text-warning" style="font-size: 2rem;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Completed Orders</h6>
                            <h3 class="mb-0 text-success">{{ $stats['completed_orders'] }}</h3>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-md-3">
             <div class="card border-0 shadow-sm">
                 <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <h6 class="text-muted mb-2">Total Spent</h6>
                             <h3 class="mb-0 text-info">${{ number_format($stats['total_spent'], 2) }}</h3>
                         </div>
                         <div class="text-info" style="font-size: 2rem;">
                             <i class="bi bi-currency-dollar"></i>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-3">
             <div class="card border-0 shadow-sm">
                 <div class="card-body">
                     <div class="d-flex justify-content-between align-items-center">
                         <div>
                             <h6 class="text-muted mb-2">Current Plan</h6>
                             <h4 class="mb-0 text-success">{{ auth()->user()->activeClientSubscription()->plan->name ?? 'Free' }}</h4>
                             <small class="text-muted">{{ auth()->user()->activeClientSubscription() ? '$' . number_format(auth()->user()->activeClientSubscription()->plan->price, 2) . '/' . auth()->user()->activeClientSubscription()->plan->billing_period : 'No subscription' }}</small>
                         </div>
                         <div class="text-success" style="font-size: 2rem;">
                             <i class="bi bi-star"></i>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
                        <div class="text-info" style="font-size: 2rem;">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                        Quick Actions
                    </h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('client.jobs.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Post a New Job
                        </a>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-cart3 me-1"></i> View Orders
                        </a>
                        <a href="#" class="btn btn-outline-success">
                            <i class="bi bi-search me-1"></i> Browse Freelancers
                        </a>
                        <a href="{{ route('client.payments') }}" class="btn btn-outline-info">
                            <i class="bi bi-credit-card me-1"></i> Payment History
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-cart-check me-2 text-primary"></i>
                            Recent Orders
                        </h5>
                        <a href="{{ route('client.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($recent_orders) && $recent_orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Seller</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('client.orders.show', $order->id) }}" class="text-decoration-none fw-bold">
                                                    #{{ $order->id }}
                                                </a>
                                            </td>
                                            <td>{{ $order->seller->name ?? 'N/A' }}</td>
                                            <td class="text-success fw-bold">${{ number_format($order->amount, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'cancelled' => 'danger'
                                                    ];
                                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $statusColor }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('client.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <p class="text-muted mt-3">No orders yet. Start by posting a job or ordering a service!</p>
                            <a href="{{ route('client.jobs.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-1"></i> Post Your First Job
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Active Jobs Summary -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-briefcase-fill text-primary me-2"></i>
                        Active Jobs
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Jobs Posted</span>
                        <span class="fw-bold">{{ $stats['posted_jobs'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Ongoing Projects</span>
                        <span class="fw-bold text-warning">{{ $stats['active_orders'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Completed</span>
                        <span class="fw-bold text-success">{{ $stats['completed_orders'] }}</span>
                    </div>
                    <hr>
                    <a href="{{ route('client.jobs.index') }}" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-list-ul me-1"></i> Manage Jobs
                    </a>
                </div>
            </div>

            <!-- Budget Overview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-pie-chart-fill text-info me-2"></i>
                        Spending Overview
                    </h6>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total Spent</span>
                            <span class="fw-bold text-success">${{ number_format($stats['total_spent'], 2) }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                    <a href="{{ route('client.payments') }}" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-credit-card me-1"></i> Payment History
                    </a>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        Tips for Clients
                    </h6>
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Write clear job descriptions</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Set realistic budgets</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Communicate expectations clearly</small>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <small>Leave reviews for completed work</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
