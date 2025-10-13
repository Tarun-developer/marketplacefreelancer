@extends('layouts.vendor')

@section('title', 'Create New Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Product</h4>
                    <p class="card-title-desc">Fill in all the details for your new product</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Product Basics Section -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">🗂️ Product Basics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="product_type" class="form-label">Product Type <span class="text-danger">*</span></label>
                                            <select name="product_type" id="product_type" class="form-select @error('product_type') is-invalid @enderror" required>
                                                <option value="">Select type</option>
                                                <option value="script" {{ old('product_type') == 'script' ? 'selected' : '' }}>Script</option>
                                                <option value="plugin" {{ old('product_type') == 'plugin' ? 'selected' : '' }}>Plugin</option>
                                                <option value="template" {{ old('product_type') == 'template' ? 'selected' : '' }}>Template</option>
                                                <option value="graphic" {{ old('product_type') == 'graphic' ? 'selected' : '' }}>Graphic</option>
                                                <option value="course" {{ old('product_type') == 'course' ? 'selected' : '' }}>Course</option>
                                                <option value="service" {{ old('product_type') == 'service' ? 'selected' : '' }}>Service</option>
                                            </select>
                                            @error('product_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description') }}" maxlength="500">
                                    <small class="text-muted">1-2 lines summary for listing previews</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Detailed Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Full product details (supports Markdown)</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                                <option value="">Select a category</option>
                                                @foreach(\App\Modules\Products\Models\Category::where('is_active', true)->get() as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="tags" class="form-label">Tags / Keywords</label>
                                            <input type="text" name="tags[]" id="tags" class="form-control" value="{{ old('tags') ? implode(', ', old('tags')) : '' }}" data-role="tagsinput">
                                            <small class="text-muted">SEO and search tags (comma separated)</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="demo_url" class="form-label">Demo URL</label>
                                            <input type="url" name="demo_url" id="demo_url" class="form-control" value="{{ old('demo_url') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="documentation_url" class="form-label">Documentation URL</label>
                                            <input type="url" name="documentation_url" id="documentation_url" class="form-control" value="{{ old('documentation_url') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="video_preview" class="form-label">Video Preview (YouTube/Vimeo)</label>
                                    <input type="url" name="video_preview" id="video_preview" class="form-control" value="{{ old('video_preview') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Pricing & Licensing Section -->
                        <div class="card border-success mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">💰 Pricing & Licensing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="standard_price" class="form-label">Standard License ($)</label>
                                            <input type="number" name="standard_price" id="standard_price" class="form-control" step="0.01" min="0" value="{{ old('standard_price') }}">
                                            <small class="text-muted">Base price for single-site usage</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="professional_price" class="form-label">Professional License ($)</label>
                                            <input type="number" name="professional_price" id="professional_price" class="form-control" step="0.01" min="0" value="{{ old('professional_price') }}">
                                            <small class="text-muted">Extended use / developer license</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="ultimate_price" class="form-label">Ultimate License ($)</label>
                                            <input type="number" name="ultimate_price" id="ultimate_price" class="form-control" step="0.01" min="0" value="{{ old('ultimate_price') }}">
                                            <small class="text-muted">Full commercial or SaaS license</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="discount_percentage" class="form-label">Discount / Flash Sale (%)</label>
                                            <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" step="0.01" min="0" max="100" value="{{ old('discount_percentage') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="is_free" id="is_free" class="form-check-input" value="1" {{ old('is_free') ? 'checked' : '' }}>
                                                <label for="is_free" class="form-check-label">
                                                    Apply for Free Download?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="money_back_guarantee" id="money_back_guarantee" class="form-check-input" value="1" {{ old('money_back_guarantee') ? 'checked' : '' }}>
                                                <label for="money_back_guarantee" class="form-check-label">
                                                    Money Back Guarantee?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="refund_days" class="form-label">Days for Refund</label>
                                            <input type="number" name="refund_days" id="refund_days" class="form-control" min="0" max="365" value="{{ old('refund_days', 30) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="refund_terms" class="form-label">Refund Terms</label>
                                    <textarea name="refund_terms" id="refund_terms" class="form-control" rows="3">{{ old('refund_terms') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Product Release & Versioning Section -->
                        <div class="card border-info mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">🧾 Product Release & Versioning</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="version" class="form-label">Version Number</label>
                                            <input type="text" name="version" id="version" class="form-control" value="{{ old('version', '1.0.0') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="release_date" class="form-label">Release Date</label>
                                            <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="changelog" class="form-label">Changelog / Release Notes</label>
                                    <textarea name="changelog" id="changelog" class="form-control" rows="4">{{ old('changelog') }}</textarea>
                                    <small class="text-muted">Supports Markdown/HTML</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="feature_update_available" id="feature_update_available" class="form-check-input" value="1" {{ old('feature_update_available') ? 'checked' : '' }}>
                                                <label for="feature_update_available" class="form-check-label">
                                                    Feature Update Available?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="item_support_available" id="item_support_available" class="form-check-input" value="1" {{ old('item_support_available') ? 'checked' : '' }}>
                                                <label for="item_support_available" class="form-check-label">
                                                    Item Support Available?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="support_duration" class="form-label">Support Duration</label>
                                    <select name="support_duration" id="support_duration" class="form-select">
                                        <option value="">Select duration</option>
                                        <option value="6_months" {{ old('support_duration') == '6_months' ? 'selected' : '' }}>6 Months</option>
                                        <option value="12_months" {{ old('support_duration') == '12_months' ? 'selected' : '' }}>12 Months</option>
                                        <option value="lifetime" {{ old('support_duration') == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Metadata & SEO Section -->
                        <div class="card border-warning mb-4">
                            <div class="card-header bg-warning">
                                <h5 class="mb-0">📊 Additional Metadata & SEO</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}" maxlength="255">
                                    <small class="text-muted">SEO title override (auto-generated if blank)</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" maxlength="500">{{ old('meta_description') }}</textarea>
                                    <small class="text-muted">For better Google visibility</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="search_keywords" class="form-label">Search Keywords</label>
                                    <input type="text" name="search_keywords[]" id="search_keywords" class="form-control" value="{{ old('search_keywords') ? implode(', ', old('search_keywords')) : '' }}" data-role="tagsinput">
                                    <small class="text-muted">Extra SEO keywords</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="canonical_url" class="form-label">Canonical URL</label>
                                    <input type="url" name="canonical_url" id="canonical_url" class="form-control" value="{{ old('canonical_url') }}">
                                    <small class="text-muted">For cross-posted products</small>
                                </div>
                            </div>
                        </div>

                        <!-- Advanced Settings Section -->
                        <div class="card border-secondary mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">🧱 Advanced Settings</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="compatible_with" class="form-label">Compatible With</label>
                                    <input type="text" name="compatible_with" id="compatible_with" class="form-control" value="{{ old('compatible_with') }}">
                                    <small class="text-muted">e.g., Laravel 11, WordPress 6.5</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="framework_technology" class="form-label">Framework / Technology Used</label>
                                    <input type="text" name="framework_technology" id="framework_technology" class="form-control" value="{{ old('framework_technology') }}">
                                    <small class="text-muted">e.g., Laravel, Vue.js, React, Flutter</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="files_included" class="form-label">Files Included</label>
                                    <input type="text" name="files_included[]" id="files_included" class="form-control" value="{{ old('files_included') ? implode(', ', old('files_included')) : '' }}" data-role="tagsinput">
                                    <small class="text-muted">e.g., PHP Files, HTML, CSS, JS, Documentation</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="requirements" class="form-label">Requirements</label>
                                    <textarea name="requirements" id="requirements" class="form-control" rows="3">{{ old('requirements') }}</textarea>
                                    <small class="text-muted">PHP version, hosting requirements, dependencies</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="estimated_delivery_time" class="form-label">Estimated Delivery Time (days)</label>
                                    <input type="number" name="estimated_delivery_time" id="estimated_delivery_time" class="form-control" min="1" max="365" value="{{ old('estimated_delivery_time') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Seller & Collaboration Section -->
                        <div class="card border-dark mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">👥 Seller & Collaboration</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="author_name" class="form-label">Author Name</label>
                                            <input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="team_name" class="form-label">Team / Agency Name</label>
                                            <input type="text" name="team_name" id="team_name" class="form-control" value="{{ old('team_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="co_authors" class="form-label">Co-Authors</label>
                                    <input type="text" name="co_authors[]" id="co_authors" class="form-control" value="{{ old('co_authors') ? implode(', ', old('co_authors')) : '' }}" data-role="tagsinput">
                                    <small class="text-muted">Add collaborators (profit split system)</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="support_email" class="form-label">Support Email</label>
                                    <input type="email" name="support_email" id="support_email" class="form-control" value="{{ old('support_email') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Status Section -->
                        <div class="card border-danger mb-4">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">⚙️ Terms & Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="license_agreement" id="license_agreement" class="form-check-input" value="1" {{ old('license_agreement') ? 'checked' : '' }}>
                                        <label for="license_agreement" class="form-check-label">
                                            License Agreement <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="terms_of_upload" id="terms_of_upload" class="form-check-input" value="1" {{ old('terms_of_upload') ? 'checked' : '' }}>
                                        <label for="terms_of_upload" class="form-check-label">
                                            Terms of Upload <span class="text-danger">*</span>
                                        </label>
                                        <small class="text-muted">I confirm ownership and copyright</small>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Product Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Create Product</button>
                            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
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