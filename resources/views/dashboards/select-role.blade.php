@extends('layouts.app')

@section('title', 'Select Role - Unlock More Features')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-plus-circle display-4 text-primary mb-3"></i>
                        <h2>Unlock More Features</h2>
                        <p class="text-muted">Choose additional roles to expand your capabilities on our platform</p>
                    </div>

                    @if(count($rolesToShow) > 0)
                        <div class="row g-4">
                            @foreach($rolesToShow as $roleKey => $role)
                                <div class="col-md-4">
                                    <div class="card border-{{ $role['color'] }} h-100 hover-card">
                                        <div class="card-body text-center">
                                            <div class="rounded-circle bg-{{ $role['color'] }} bg-opacity-10 p-3 mx-auto mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi {{ $role['icon'] }} fs-2 text-{{ $role['color'] }}"></i>
                                            </div>
                                            <h5 class="mb-2">{{ $role['name'] }}</h5>
                                            <p class="text-muted small mb-3">{{ $role['description'] }}</p>

                                            @if($role['cost'] > 0)
                                                <div class="mb-3">
                                                    <span class="h4 text-{{ $role['color'] }}">${{ number_format($role['cost'], 2) }}</span>
                                                    <small class="text-muted">one-time fee</small>
                                                </div>
                                                <a href="{{ route('checkout', $roleKey) }}" class="btn btn-{{ $role['color'] }} w-100">
                                                    <i class="bi bi-credit-card me-2"></i>Purchase Role
                                                </a>
                                            @else
                                                <div class="mb-3">
                                                    <span class="badge bg-success">FREE</span>
                                                </div>
                                                <a href="{{ route('checkout', $roleKey) }}" class="btn btn-{{ $role['color'] }} w-100">
                                                    <i class="bi bi-check-circle me-2"></i>Get Role
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-check-circle display-4 text-success mb-3"></i>
                            <h4>You have all available roles!</h4>
                            <p class="text-muted">You can now access all features of the platform.</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endsection