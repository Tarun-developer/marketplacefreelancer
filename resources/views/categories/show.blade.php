@extends('layouts.admin')

@section('title', 'Category Details')

@section('page-title', 'Category Details')

@section('content')
    <h1 class="h3 mb-4">Category Details</h1>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $category->name }}</dd>

                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9">{{ $category->slug }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $category->description }}</dd>
            </dl>

            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection