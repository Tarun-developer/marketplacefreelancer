@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Edit Product: {{ $product->name }}</h4>
                    <div>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">View Product</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back to Products</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Basic Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="product_type" class="form-label">Product Type</label>
                                            <select name="product_type" id="product_type" class="form-select">
                                                <option value="script" {{ old('product_type', $product->product_type) == 'script' ? 'selected' : '' }}>Script</option>
                                                <option value="plugin" {{ old('product_type', $product->product_type) == 'plugin' ? 'selected' : '' }}>Plugin</option>
                                                <option value="template" {{ old('product_type', $product->product_type) == 'template' ? 'selected' : '' }}>Template</option>
                                                <option value="graphic" {{ old('product_type', $product->product_type) == 'graphic' ? 'selected' : '' }}>Graphic</option>
                                                <option value="course" {{ old('product_type', $product->product_type) == 'course' ? 'selected' : '' }}>Course</option>
                                                <option value="service" {{ old('product_type', $product->product_type) == 'service' ? 'selected' : '' }}>Service</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description', $product->short_description) }}" maxlength="500">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select name="category_id" id="category_id" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach(\App\Modules\Products\Models\Category::where('is_active', true)->get() as $category)
                                                    <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="version" class="form-label">Version</label>
                                            <input type="text" name="version" id="version" class="form-control" value="{{ old('version', $product->version) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card border-success mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Pricing & Licensing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="standard_price" class="form-label">Standard License ($)</label>
                                            <input type="number" name="standard_price" id="standard_price" class="form-control" step="0.01" min="0" value="{{ old('standard_price', $product->standard_price) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="professional_price" class="form-label">Professional License ($)</label>
                                            <input type="number" name="professional_price" id="professional_price" class="form-control" step="0.01" min="0" value="{{ old('professional_price', $product->professional_price) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="ultimate_price" class="form-label">Ultimate License ($)</label>
                                            <input type="number" name="ultimate_price" id="ultimate_price" class="form-control" step="0.01" min="0" value="{{ old('ultimate_price', $product->ultimate_price) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="discount_percentage" class="form-label">Discount (%)</label>
                                            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" step="0.01" min="0" max="100" value="{{ old('discount_percentage', $product->discount_percentage) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="is_free" id="is_free" class="form-check-input" value="1" {{ old('is_free', $product->is_free) ? 'checked' : '' }}>
                                                <label for="is_free" class="form-check-label">
                                                    Free Product
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Media Upload -->
                        <div class="card border-info mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Media Management</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="thumbnail" class="form-label">Thumbnail</label>
                                            <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
                                            @if($product->thumbnail)
                                                <small class="text-muted">Current: <a href="{{ asset('storage/' . $product->thumbnail) }}" target="_blank">View</a></small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="screenshots" class="form-label">Screenshots</label>
                                            <input type="file" name="screenshots[]" id="screenshots" class="form-control" accept="image/*" multiple>
                                            @if($product->screenshots && count($product->screenshots) > 0)
                                                <small class="text-muted">Current: {{ count($product->screenshots) }} images</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="main_file" class="form-label">Main File (ZIP)</label>
                                    <input type="file" name="main_file" id="main_file" class="form-control" accept=".zip,.rar">
                                    @if($product->file_path)
                                        <small class="text-muted">Current: {{ number_format($product->file_size / 1024 / 1024, 2) }} MB</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- SEO & Metadata -->
                        <div class="card border-warning mb-4">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0">SEO & Metadata</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}" maxlength="255">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" maxlength="500">{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="search_keywords" class="form-label">Search Keywords</label>
                                    <input type="text" name="search_keywords[]" id="search_keywords" class="form-control" value="{{ old('search_keywords', $product->search_keywords ? implode(', ', $product->search_keywords) : '') }}" data-role="tagsinput">
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings -->
                        <div class="card border-secondary mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Advanced Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="compatible_with" class="form-label">Compatible With</label>
                                            <input type="text" name="compatible_with" id="compatible_with" class="form-control" value="{{ old('compatible_with', $product->compatible_with) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="framework_technology" class="form-label">Framework/Technology</label>
                                            <input type="text" name="framework_technology" id="framework_technology" class="form-control" value="{{ old('framework_technology', $product->framework_technology) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="files_included" class="form-label">Files Included</label>
                                    <input type="text" name="files_included[]" id="files_included" class="form-control" value="{{ old('files_included', $product->files_included ? implode(', ', $product->files_included) : '') }}" data-role="tagsinput">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea name="requirements" id="requirements" class="form-control" rows="3">{{ old('requirements', $product->requirements) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estimated_delivery_time" class="form-label">Estimated Delivery Time (days)</label>
                                    <input type="number" name="estimated_delivery_time" id="estimated_delivery_time" class="form-control" min="1" max="365" value="{{ old('estimated_delivery_time', $product->estimated_delivery_time) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Approval & Status -->
                        <div class="card border-danger mb-4">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">Approval & Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="is_approved" class="form-label">Approval Status</label>
                                            <select name="is_approved" id="is_approved" class="form-select">
                                                <option value="0" {{ old('is_approved', $product->is_approved) ? 'selected' : '' }}>Pending</option>
                                                <option value="1" {{ old('is_approved', $product->is_approved) ? 'selected' : '' }}>Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="status" class="form-label">Product Status</label>
                                            <select name="status" id="status" class="form-select">
                                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="suspended" {{ old('status', $product->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="is_featured" class="form-label">Featured Product</label>
                                    <select name="is_featured" id="is_featured" class="form-select">
                                        <option value="0" {{ old('is_featured', $product->is_featured) ? '' : 'selected' }}>No</option>
                                        <option value="1" {{ old('is_featured', $product->is_featured) ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Update Product</button>
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary btn-lg">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize tags input
    $('input[data-role="tagsinput"]').tagsinput();
</script>
@endpush
@endsection