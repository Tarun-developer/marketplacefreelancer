@extends('layouts.admin')

@section('title', 'Settings Management')
@section('page-title', 'Settings Management')

@section('content')
<div class="container-fluid">
    <!-- Settings Form -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">General Settings</h5>
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="site_name" class="form-label">Site Name</label>
                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', config('app.name')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="site_email" class="form-label">Site Email</label>
                        <input type="email" name="site_email" id="site_email" class="form-control" value="{{ old('site_email', config('mail.from.address')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="default_currency" class="form-label">Default Currency</label>
                        <select name="default_currency" id="default_currency" class="form-select">
                            <option value="USD" {{ config('app.currency') === 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ config('app.currency') === 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ config('app.currency') === 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="commission_rate" class="form-label">Default Commission Rate (%)</label>
                        <input type="number" name="commission_rate" id="commission_rate" class="form-control" step="0.01" value="{{ old('commission_rate', 15.00) }}">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection