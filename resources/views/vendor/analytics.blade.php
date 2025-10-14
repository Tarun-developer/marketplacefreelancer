@extends('layouts.vendor')

@section('title', 'Analytics')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Analytics Dashboard</h1>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text display-4">{{ $stats['total_products'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Orders</h5>
                            <p class="card-text display-4">{{ $stats['total_orders'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Sales</h5>
                            <p class="card-text display-4">${{ number_format($stats['total_sales'], 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Monthly Sales</h5>
                            <p class="card-text display-4">${{ number_format($stats['monthly_sales'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add more analytics sections here if needed -->
        </div>
    </div>
</div>
@endsection