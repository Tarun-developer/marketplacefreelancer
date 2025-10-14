@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Edit Payment Gateway</h1>
            <p class="text-muted">Update {{ $paymentGateway->name }} configuration</p>
        </div>
        <a href="{{ route('admin.payment-gateways.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('admin.payment-gateways.update', $paymentGateway) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.payment-gateways.form')
    </form>
</div>
@endsection
