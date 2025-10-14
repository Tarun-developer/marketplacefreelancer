@extends('layouts.client')

@section('title', $service->title)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('client.services.index') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Services
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-truncate">{{ Str::limit($service->title, 30) }}</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Service Details -->
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-tools fa-lg"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h2 class="h4 mb-2">{{ $service->title }}</h2>
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-user me-2"></i>By {{ $service->user->name }}
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-2">
                                            <i class="fas fa-circle me-1"></i>{{ ucfirst($service->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div>
                                <h5 class="mb-3">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Description
                                </h5>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0">{{ $service->description }}</p>
                                </div>
                            </div>

                            @if($service->tags->count() > 0)
                                <div class="mt-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-tags me-2 text-primary"></i>Tags
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($service->tags as $tag)
                                            <span class="badge bg-outline-primary px-3 py-2">
                                                <i class="fas fa-tag me-1"></i>{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Service Summary -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Service Details
                            </h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-dollar-sign me-2"></i>Price:</span>
                                        <strong>${{ number_format($service->price, 2) }} {{ $service->currency }}</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-calendar me-2"></i>Delivery Time:</span>
                                        <strong>{{ $service->delivery_time }} days</strong>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                        <span><i class="fas fa-user me-2"></i>Freelancer:</span>
                                        <strong>{{ $service->user->name }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Form -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-shopping-cart me-2 text-primary"></i>Purchase Service
                            </h5>
                            <form action="{{ route('client.services.purchase', $service) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea class="form-control" id="requirements" name="requirements" rows="4" placeholder="Describe your requirements for this service..." required></textarea>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-credit-card me-2"></i>Purchase for ${{ number_format($service->price, 2) }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection