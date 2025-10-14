@extends('layouts.freelancer')

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Service</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('freelancer.services.update', $service) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Service Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $service->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $service->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach(\App\Modules\Products\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" value="{{ $service->price }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" id="currency" name="currency" required>
                                    <option value="USD" {{ $service->currency == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ $service->currency == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ $service->currency == 'GBP' ? 'selected' : '' }}>GBP</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="delivery_time" class="form-label">Delivery Time (days)</label>
                            <input type="number" class="form-control" id="delivery_time" name="delivery_time" min="1" value="{{ $service->delivery_time }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags (comma separated)</label>
                            <input type="text" class="form-control" id="tags" name="tags" value="{{ $service->tags->pluck('name')->implode(', ') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Service</button>
                        <a href="{{ route('freelancer.services.show', $service) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection