@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Add Payment Gateway</h1>
            <p class="text-muted">Configure a new payment processor</p>
        </div>
        <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('admin.payment-gateways.store') }}" method="POST">
        @csrf
        @include('admin.payment-gateways.form')
    </form>
</div>
@endsection
