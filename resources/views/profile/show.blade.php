@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Profile Header -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <img src="{{ $user->getFirstMediaUrl('avatar', 'thumb') ?: 'data:image/svg+xml;base64,' . base64_encode('<svg width="150" height="150" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg"><rect width="150" height="150" fill="#6B46C1"/><text x="75" y="85" font-family="Arial" font-size="60" font-weight="bold" text-anchor="middle" fill="white">' . substr($user->name, 0, 1) . '</text></svg>') }}"
                                 alt="Profile Picture"
                                 class="rounded-circle mb-3"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <h3>{{ $user->name }}</h3>
                            <p class="text-muted">{{ $user->getRoleNames()->first() ? ucfirst($user->getRoleNames()->first()) : 'User' }}</p>

                            <!-- Rating Display -->
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

                            <!-- Badges -->
                            @if($badges)
                                <div class="mb-3">
                                    @foreach($badges as $badge)
                                        <span class="badge bg-{{ $badge['color'] }} me-1 mb-1">
                                            <i class="bi {{ $badge['icon'] }} me-1"></i>{{ $badge['name'] }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="col-md-9">
                            <h4>About</h4>
                            @if($user->profile && $user->profile->bio)
                                <p>{{ $user->profile->bio }}</p>
                            @else
                                <p class="text-muted">No bio available.</p>
                            @endif

                            @if($user->profile && $user->profile->skills)
                                <div class="mb-3">
                                    <h6>Skills</h6>
                                    <div>
                                        @foreach($user->profile->skills as $skill)
                                            <span class="badge bg-secondary me-1">{{ $skill }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($user->profile && $user->profile->location)
                                <p><i class="bi bi-geo-alt me-2"></i>{{ $user->profile->location }}</p>
                            @endif

                            @if($user->profile && $user->profile->portfolio_url)
                                <p><i class="bi bi-link me-2"></i><a href="{{ $user->profile->portfolio_url }}" target="_blank">Portfolio</a></p>
                            @endif

                            <div class="d-flex gap-2">
                                <a href="{{ route('users.reviews', $user) }}" class="btn btn-outline-primary">View Reviews</a>
                                @auth
                                    @if(auth()->id() !== $user->id)
                                        <button class="btn btn-primary" onclick="contactUser({{ $user->id }})">Contact</button>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role-specific Content -->
        @if($user->hasRole('freelancer'))
            @include('profile.partials.freelancer', compact('user'))
        @elseif($user->hasRole('vendor'))
            @include('profile.partials.vendor', compact('user'))
        @elseif($user->hasRole('client'))
            @include('profile.partials.client', compact('user'))
        @endif
    </div>
</div>

<script>
function contactUser(userId) {
    // Implement contact functionality (e.g., open chat or send message)
    window.location.href = '{{ route("messages.start", "") }}/' + userId;
}
</script>
@endsection