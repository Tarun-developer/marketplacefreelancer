@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.show', $user) }}">{{ $user->name }}'s Profile</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- User Info -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') ?: 'data:image/svg+xml;base64,' . base64_encode('<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><rect width="100" height="100" fill="#6B46C1"/><text x="50" y="60" font-family="Arial" font-size="40" font-weight="bold" text-anchor="middle" fill="white">' . substr($user->name, 0, 1) . '</text></svg>') }}"
                         alt="Profile Picture"
                         class="rounded-circle mb-3"
                         style="width: 100px; height: 100px; object-fit: cover;">
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->getRoleNames()->first() ? ucfirst($user->getRoleNames()->first()) : 'User' }}</p>

                    <!-- Overall Rating -->
                    @php
                        $averageRating = $user->reviews()->avg('rating') ?? 0;
                        $totalReviews = $user->reviews()->count();
                    @endphp
                    <div class="mb-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $averageRating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                            <span class="fw-bold">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-muted ms-1">({{ $totalReviews }} reviews)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Reviews ({{ $reviews->total() }})</h5>
                </div>
                <div class="card-body">
                    @if($reviews->count() > 0)
                        @foreach($reviews as $review)
                            <div class="review-item mb-4 pb-4 border-bottom">
                                <div class="d-flex align-items-start">
                                    <img src="{{ $review->reviewer->getFirstMediaUrl('avatar', 'thumb') ?: 'data:image/svg+xml;base64,' . base64_encode('<svg width="50" height="50" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"><rect width="50" height="50" fill="#6B46C1"/><text x="25" y="30" font-family="Arial" font-size="20" font-weight="bold" text-anchor="middle" fill="white">' . substr($review->reviewer->name, 0, 1) . '</text></svg>') }}"
                                         alt="Reviewer"
                                         class="rounded-circle me-3"
                                         style="width: 50px; height: 50px;">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h6 class="mb-0 me-2">{{ $review->reviewer->name }}</h6>
                                            <div class="me-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                @endfor
                                            </div>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                        @if($review->comment)
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        @endif
                                        @if($review->order)
                                            <small class="text-muted">Review for order #{{ $review->order->id }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <p class="text-center text-muted py-4">No reviews yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection