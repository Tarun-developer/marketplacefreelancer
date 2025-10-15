<!-- Client-specific Profile Content -->
<div class="col-12">
    <div class="row">
        <!-- Posted Jobs -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>My Jobs</h5>
                </div>
                <div class="card-body">
                    @if($user->jobs->count() > 0)
                        <div class="row">
                            @foreach($user->jobs->take(3) as $job)
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $job->title }}</h6>
                                            <small class="text-muted">${{ $job->budget_min }} - ${{ $job->budget_max }}</small>
                                        </div>
                                        <span class="badge bg-{{ $job->status === 'completed' ? 'success' : 'primary' }}">{{ ucfirst($job->status) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('client.jobs.index') }}" class="btn btn-sm btn-outline-primary mt-2">View All Jobs</a>
                    @else
                        <p class="text-muted mb-0">No jobs posted yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-cart-check me-2"></i>My Orders</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalOrders = $user->ordersAsBuyer->count();
                        $completedOrders = $user->ordersAsBuyer->where('status', 'completed')->count();
                    @endphp
                    <div class="text-center">
                        <h2 class="text-primary">{{ $totalOrders }}</h2>
                        <p class="text-muted">Total Orders</p>
                        <h4 class="text-success">{{ $completedOrders }} Completed</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Spending -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Total Spending</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalSpent = $user->ordersAsBuyer->where('status', 'completed')->sum('amount');
                    @endphp
                    <div class="text-center">
                        <h2 class="text-warning">${{ number_format($totalSpent, 2) }}</h2>
                        <p class="text-muted">Total Spent</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Reviews Given</h5>
                </div>
                <div class="card-body">
                    @if($user->reviews->count() > 0)
                        @foreach($user->reviews->take(3) as $review)
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <h6 class="mb-0">{{ $review->reviewee->name }}</h6>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-0 text-muted">{{ Str::limit($review->comment, 100) }}</p>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('users.reviews', $user) }}" class="btn btn-sm btn-outline-primary">View All Reviews</a>
                    @else
                        <p class="text-muted">No reviews given yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>