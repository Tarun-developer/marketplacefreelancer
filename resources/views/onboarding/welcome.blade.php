@extends('onboarding.layout')

@section('title', 'Welcome')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
            <i class="bi bi-star fs-2"></i>
        </div>
    </div>

    <h1 class="mb-3">Welcome to {{ config('app.name') }}!</h1>
    <p class="lead text-muted mb-4">Let's get you set up in just a few simple steps</p>

    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3">What you'll accomplish:</h5>
                    <div class="row text-start">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    <i class="bi bi-check"></i>
                                </div>
                                <span>Choose your role (Client, Freelancer, or Vendor)</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    <i class="bi bi-check"></i>
                                </div>
                                <span>Set up your profile and skills</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    <i class="bi bi-check"></i>
                                </div>
                                <span>Complete identity verification</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 30px; height: 30px;">
                                    <i class="bi bi-check"></i>
                                </div>
                                <span>Start using your personalized dashboard</span>
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
            <i class="bi bi-arrow-right me-2"></i>Let's Get Started
        </button>
    </form>
</div>
@endsection