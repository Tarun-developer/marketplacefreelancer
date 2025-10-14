@extends('layouts.admin')

@section('title', 'Create Subscription Plan')
@section('page-title', 'Create Subscription Plan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Subscription Plan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscription-plans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Plan Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="freelancer">Freelancer</option>
                                <option value="spm">SPM</option>
                                <option value="vendor">Vendor</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="billing_period" class="form-label">Billing Period</label>
                            <select class="form-select" id="billing_period" name="billing_period" required>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features (one per line)</label>
                            <textarea class="form-control" id="features" name="features" rows="5" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Plan</button>
                        <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection