@extends('layouts.freelancer')

@section('title', 'Freelancer Dashboard')

@section('page-title', 'Freelancer Dashboard')

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Active Gigs</h6>
                    <h3 class="mt-2 text-primary">5</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Completed Jobs</h6>
                    <h3 class="mt-2 text-success">12</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted">Total Earnings</h6>
                    <h3 class="mt-2 text-info">$850</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Recent Activity</h5>
            <p class="card-text">Welcome to your freelancer dashboard. Manage your services and track your projects here.</p>
        </div>
    </div>
@endsection