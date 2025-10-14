@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')
@section('page-title', 'Edit Subscription Plan')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Subscription Plan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.subscription-plans.update', $subscription_plan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $subscription_plan->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $subscription_plan->price }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="features" class="form-label">Features (one per line)</label>
                            <textarea class="form-control" id="features" name="features" rows="5" required>{{ is_array($subscription_plan->features) ? implode("\n", $subscription_plan->features) : $subscription_plan->features }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $subscription_plan->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Plan</button>
                        <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection