<!-- Vendor-specific Profile Content -->
<div class="col-12">
    <div class="row">
        <!-- Products -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>My Products</h5>
                </div>
                <div class="card-body">
                    @if($user->products->count() > 0)
                        <div class="row">
                            @foreach($user->products->take(3) as $product)
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $product->name }}</h6>
                                            <small class="text-muted">${{ $product->price }}</small>
                                        </div>
                                        <span class="badge bg-success">{{ $product->orders->where('status', 'completed')->count() }} sales</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-outline-primary mt-2">View All Products</a>
                    @else
                        <p class="text-muted mb-0">No products created yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Services -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-tools me-2"></i>My Services</h5>
                </div>
                <div class="card-body">
                    @if($user->services->count() > 0)
                        <div class="row">
                            @foreach($user->services->take(3) as $service)
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $service->title }}</h6>
                                            <small class="text-muted">${{ $service->price }}</small>
                                        </div>
                                        <span class="badge bg-success">{{ $service->orders->where('status', 'completed')->count() }} completed</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('vendor.services.index') }}" class="btn btn-sm btn-outline-primary mt-2">View All Services</a>
                    @else
                        <p class="text-muted mb-0">No services created yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sales Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Sales Overview</h5>
                </div>
                <div class="card-body">
                    @php
                        $totalSales = $user->ordersAsSeller->count();
                        $completedSales = $user->ordersAsSeller->where('status', 'completed')->count();
                        $totalEarnings = $user->ordersAsSeller->where('status', 'completed')->sum('amount');
                    @endphp
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-primary">{{ $totalSales }}</h4>
                            <small class="text-muted">Total Orders</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">{{ $completedSales }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning">${{ number_format($totalEarnings, 2) }}</h4>
                            <small class="text-muted">Earnings</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Customer Reviews</h5>
                </div>
                <div class="card-body">
                    @if($user->reviews->count() > 0)
                        @foreach($user->reviews->take(3) as $review)
                            <div class="d-flex align-items-start mb-3">
                                <img src="{{ $review->reviewer->getFirstMediaUrl('avatar', 'thumb') ?: 'data:image/svg+xml;base64,' . base64_encode('<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" fill="#D69E2E"/><text x="20" y="25" font-family="Arial" font-size="16" font-weight="bold" text-anchor="middle" fill="white">' . substr($review->reviewer->name, 0, 1) . '</text></svg>') }}"
                                     alt="Reviewer"
                                     class="rounded-circle me-3"
                                     style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <strong>{{ $review->reviewer->name }}</strong>
                                        <div class="ms-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mb-0 text-muted">{{ Str::limit($review->comment, 100) }}</p>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('users.reviews', $user) }}" class="btn btn-sm btn-outline-primary">View All Reviews</a>
                    @else
                        <p class="text-muted">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>