@extends('onboarding.layout')

@section('title', 'Setup Complete')

@section('content')
<div class="py-5">
    <div class="text-center">
        <div class="mb-4">
            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="bi bi-check-circle fs-2"></i>
            </div>
        </div>

        <h1 class="mb-3">🎉 Setup Complete!</h1>
        <p class="lead text-muted mb-4">Welcome to {{ config('app.name') }}! Your account is ready to use.</p>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">What's Next?</h5>
                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                        <i class="bi bi-1-circle"></i>
                                    </div>
                                    <div>
                                        <strong>Explore Your Dashboard</strong>
                                        <br><small class="text-muted">Customize your experience</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                        <i class="bi bi-2-circle"></i>
                                    </div>
                                    <div>
                                        <strong>Complete Your Profile</strong>
                                        <br><small class="text-muted">Add more details and photos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                        <i class="bi bi-3-circle"></i>
                                    </div>
                                    <div>
                                        <strong>Start Using Features</strong>
                                        <br><small class="text-muted">Post jobs, offer services, or sell products</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                        <i class="bi bi-4-circle"></i>
                                    </div>
                                    <div>
                                        <strong>Buy Premium Features</strong>
                                        <br><small class="text-muted">Unlock advanced tools and features</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('onboarding.process') }}">
            @csrf
            <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-rocket me-2"></i>Go to My Dashboard
            </button>
        </form>

        <div class="mt-3">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                You can always update your profile and settings from your dashboard
            </small>
        </div>
    </div>
</div>
@endsection