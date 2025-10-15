@extends('onboarding.layout')

@section('title', 'Identity Verification')

@section('content')
<div class="py-4">
    <div class="text-center mb-4">
        <h2 class="mb-3">Verify Your Identity</h2>
        <p class="text-muted">Complete verification to unlock all platform features and build trust</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h5>Why Verify Your Identity?</h5>
                        <p class="text-muted">Verification helps build trust and unlocks premium features</p>
                    </div>

                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-3">
                                <i class="bi bi-check-circle-fill text-success fs-3 mb-2"></i>
                                <h6>Increased Trust</h6>
                                <small class="text-muted">Verified users get priority placement</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3">
                                <i class="bi bi-unlock-fill text-primary fs-3 mb-2"></i>
                                <h6>Premium Features</h6>
                                <small class="text-muted">Access to advanced tools and features</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3">
                                <i class="bi bi-graph-up text-info fs-3 mb-2"></i>
                                <h6>Better Visibility</h6>
                                <small class="text-muted">Appear higher in search results</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>For Demo Purposes:</strong> In this demo, we'll mark your verification as "pending". In production, you would upload government ID, proof of address, and complete video verification.
                    </div>

                    <div class="text-center">
                        <p class="mb-3">Ready to get verified?</p>
                        <form method="POST" action="{{ route('onboarding.process') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg px-5">
                                <i class="bi bi-check-circle me-2"></i>Complete Verification (Demo)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Verification Requirements -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Verification Requirements</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Government ID</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check text-success me-2"></i>Passport</li>
                                <li><i class="bi bi-check text-success me-2"></i>Driver's License</li>
                                <li><i class="bi bi-check text-success me-2"></i>National ID Card</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Proof of Address</h6>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check text-success me-2"></i>Utility Bill</li>
                                <li><i class="bi bi-check text-success me-2"></i>Bank Statement</li>
                                <li><i class="bi bi-check text-success me-2"></i>Official Letter</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection