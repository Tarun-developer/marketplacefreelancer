 @extends('layouts.admin')

 @section('title', 'Edit Product')
 @section('page-title', 'Edit Product')

 @push('styles')
 <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" type="text/css" />
 <style>
     .dropzone {
         border: 2px dashed #007bff;
         border-radius: 5px;
         background: #f8f9fa;
         padding: 20px;
         text-align: center;
         cursor: pointer;
         transition: all 0.3s ease;
     }
     .dropzone:hover {
         background: #e3f2fd;
     }
     .dropzone.dz-drag-hover {
         border-color: #28a745;
         background: #d4edda;
     }
     .progress {
         height: 20px;
     }
     .thumbnail-preview {
         max-width: 100px;
         max-height: 100px;
         margin: 5px;
     }
 </style>
 @endpush

 @section('content')
     <div class="row">
         <div class="col-md-8">
             <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="product-form">
                 @csrf
                 @method('PUT')
                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">File Uploads</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <label class="form-label">Thumbnail</label>
                                 <div id="thumbnail-dropzone" class="dropzone">
                                     <span>Drag & drop thumbnail here or click to browse</span>
                                 </div>
                                 <input type="hidden" name="thumbnail" id="thumbnail-input">
                                 <div id="thumbnail-preview" class="mt-2">
                                     @if($product->getFirstMediaUrl('thumbnail'))
                                         <img src="{{ $product->getFirstMediaUrl('thumbnail') }}" class="thumbnail-preview img-thumbnail">
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <label class="form-label">Screenshots</label>
                                 <div id="screenshots-dropzone" class="dropzone">
                                     <span>Drag & drop screenshots here or click to browse</span>
                                 </div>
                                 <input type="hidden" name="screenshots" id="screenshots-input">
                                 <div id="screenshots-preview" class="mt-2">
                                     @foreach($product->getMedia('screenshots') as $media)
                                         <img src="{{ $media->getUrl() }}" class="thumbnail-preview img-thumbnail">
                                     @endforeach
                                 </div>
                             </div>
                         </div>
                         <div class="row mt-3">
                             <div class="col-md-6">
                                 <label class="form-label">Main File</label>
                                 <div id="main-file-dropzone" class="dropzone">
                                     <span>Drag & drop main file here or click to browse</span>
                                 </div>
                                 <input type="hidden" name="main_file" id="main-file-input">
                                 <div id="main-file-preview" class="mt-2">
                                     @if($product->getFirstMediaUrl('main_file'))
                                         <p>{{ basename($product->getFirstMediaUrl('main_file')) }}</p>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <label class="form-label">Preview File (optional)</label>
                                 <div id="preview-file-dropzone" class="dropzone">
                                     <span>Drag & drop preview file here or click to browse</span>
                                 </div>
                                 <input type="hidden" name="preview_file" id="preview-file-input">
                                 <div id="preview-file-preview" class="mt-2">
                                     @if($product->getFirstMediaUrl('preview_file'))
                                         <p>{{ basename($product->getFirstMediaUrl('preview_file')) }}</p>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Basic Details</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="name" class="form-label">Product Name *</label>
                                     <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="slug" class="form-label">Slug</label>
                                     <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $product->slug) }}">
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="short_description" class="form-label">Short Description</label>
                             <textarea name="short_description" id="short_description" rows="3" class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                         </div>
                         <div class="mb-3">
                             <label for="description" class="form-label">Full Description *</label>
                             <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="product_type" class="form-label">Product Type</label>
                                     <select name="product_type" id="product_type" class="form-select">
                                         <option value="theme" {{ old('product_type', $product->product_type ?? 'theme') == 'theme' ? 'selected' : '' }}>Theme</option>
                                         <option value="plugin" {{ old('product_type', $product->product_type) == 'plugin' ? 'selected' : '' }}>Plugin</option>
                                         <option value="template" {{ old('product_type', $product->product_type) == 'template' ? 'selected' : '' }}>Template</option>
                                         <option value="other" {{ old('product_type', $product->product_type) == 'other' ? 'selected' : '' }}>Other</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="framework_technology" class="form-label">Framework/Technology</label>
                                     <input type="text" name="framework_technology" id="framework_technology" class="form-control" value="{{ old('framework_technology', $product->framework_technology) }}">
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="tags" class="form-label">Tags (comma separated)</label>
                             <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}">
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="demo_url" class="form-label">Demo URL</label>
                                     <input type="url" name="demo_url" id="demo_url" class="form-control" value="{{ old('demo_url', $product->demo_url) }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="documentation_url" class="form-label">Documentation URL</label>
                                     <input type="url" name="documentation_url" id="documentation_url" class="form-control" value="{{ old('documentation_url', $product->documentation_url) }}">
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Category & Taxonomy</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="category_id" class="form-label">Main Category *</label>
                                     <select name="category_id" id="category_id" class="form-select" required>
                                         <option value="">Select Category</option>
                                         @foreach($categories as $category)
                                             <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="subcategory_id" class="form-label">Subcategory</label>
                                     <select name="subcategory_id" id="subcategory_id" class="form-select">
                                         <option value="">Select Subcategory</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Pricing & Licensing</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-4">
                                 <div class="mb-3">
                                     <label for="standard_price" class="form-label">Standard Price ($)</label>
                                     <input type="number" name="standard_price" id="standard_price" class="form-control" value="{{ old('standard_price', $product->standard_price) }}" step="0.01">
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <div class="mb-3">
                                     <label for="professional_price" class="form-label">Professional Price ($)</label>
                                     <input type="number" name="professional_price" id="professional_price" class="form-control" value="{{ old('professional_price', $product->professional_price) }}" step="0.01">
                                 </div>
                             </div>
                             <div class="col-md-4">
                                 <div class="mb-3">
                                     <label for="extended_price" class="form-label">Extended Price ($)</label>
                                     <input type="number" name="extended_price" id="extended_price" class="form-control" value="{{ old('extended_price', $product->extended_price) }}" step="0.01">
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="discount_percentage" class="form-label">Discount (%)</label>
                                     <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" value="{{ old('discount_percentage', $product->discount_percentage) }}" min="0" max="100" step="0.01">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3 form-check">
                                     <input type="checkbox" name="is_flash_sale" id="is_flash_sale" class="form-check-input" {{ old('is_flash_sale', $product->is_flash_sale) ? 'checked' : '' }}>
                                     <label for="is_flash_sale" class="form-check-label">Flash Sale</label>
                                 </div>
                                 <div class="mb-3 form-check">
                                     <input type="checkbox" name="is_free" id="is_free" class="form-check-input" {{ old('is_free', $product->is_free) ? 'checked' : '' }}>
                                     <label for="is_free" class="form-check-label">Free Product</label>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Version & Release</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="version" class="form-label">Version</label>
                                     <input type="text" name="version" id="version" class="form-control" value="{{ old('version', $product->version ?? '1.0.0') }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="release_date" class="form-label">Release Date</label>
                                     <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date', $product->release_date ? $product->release_date->format('Y-m-d') : '') }}">
                                 </div>
                             </div>
                         </div>
                         <div class="mb-3">
                             <label for="changelog" class="form-label">Changelog</label>
                             <textarea name="changelog" id="changelog" rows="4" class="form-control">{{ old('changelog', $product->changelog) }}</textarea>
                         </div>
                         <div class="mb-3 form-check">
                             <input type="checkbox" name="has_feature_updates" id="has_feature_updates" class="form-check-input" {{ old('has_feature_updates', $product->has_feature_updates) ? 'checked' : '' }}>
                             <label for="has_feature_updates" class="form-check-label">Has Feature Updates</label>
                         </div>
                         <div class="mb-3">
                             <label for="auto_update_url" class="form-label">Auto Update URL</label>
                             <input type="url" name="auto_update_url" id="auto_update_url" class="form-control" value="{{ old('auto_update_url', $product->auto_update_url) }}">
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Support & Policy</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3 form-check">
                                     <input type="checkbox" name="has_support" id="has_support" class="form-check-input" {{ old('has_support', $product->has_support) ? 'checked' : '' }}>
                                     <label for="has_support" class="form-check-label">Has Support</label>
                                 </div>
                                 <div class="mb-3">
                                     <label for="support_duration" class="form-label">Support Duration (months)</label>
                                     <input type="number" name="support_duration" id="support_duration" class="form-control" value="{{ old('support_duration', $product->support_duration) }}" min="1">
                                 </div>
                                 <div class="mb-3">
                                     <label for="support_link" class="form-label">Support Link</label>
                                     <input type="url" name="support_link" id="support_link" class="form-control" value="{{ old('support_link', $product->support_link) }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3 form-check">
                                     <input type="checkbox" name="has_refund_guarantee" id="has_refund_guarantee" class="form-check-input" {{ old('has_refund_guarantee', $product->has_refund_guarantee) ? 'checked' : '' }}>
                                     <label for="has_refund_guarantee" class="form-check-label">Refund Guarantee</label>
                                 </div>
                                 <div class="mb-3">
                                     <label for="refund_days" class="form-label">Refund Days</label>
                                     <input type="number" name="refund_days" id="refund_days" class="form-control" value="{{ old('refund_days', $product->refund_days) }}" min="1">
                                 </div>
                                 <div class="mb-3">
                                     <label for="refund_terms" class="form-label">Refund Terms</label>
                                     <textarea name="refund_terms" id="refund_terms" rows="3" class="form-control">{{ old('refund_terms', $product->refund_terms) }}</textarea>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Status & Visibility</h5>
                     </div>
                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3 form-check">
                                     <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                     <label for="is_featured" class="form-check-label">Featured Product</label>
                                 </div>
                                 <div class="mb-3">
                                     <label for="visibility" class="form-label">Visibility</label>
                                     <select name="visibility" id="visibility" class="form-select">
                                         <option value="public" {{ old('visibility', $product->visibility ?? 'public') == 'public' ? 'selected' : '' }}>Public</option>
                                         <option value="private" {{ old('visibility', $product->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                                         <option value="draft" {{ old('visibility', $product->visibility) == 'draft' ? 'selected' : '' }}>Draft</option>
                                     </select>
                                 </div>
                                 <div class="mb-3">
                                     <label for="publish_date" class="form-label">Publish Date</label>
                                     <input type="datetime-local" name="publish_date" id="publish_date" class="form-control" value="{{ old('publish_date', $product->publish_date ? $product->publish_date->format('Y-m-d\TH:i') : '') }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="status" class="form-label">Status</label>
                                     <select name="status" id="status" class="form-select">
                                         <option value="active" {{ old('status', $product->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                         <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                         <option value="pending" {{ old('status', $product->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                     </select>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Author & Attribution</h5>
                     </div>
                     <div class="card-body">
                         <div class="mb-3">
                             <label for="team_members" class="form-label">Team Members (JSON array)</label>
                             <textarea name="team_members" id="team_members" rows="3" class="form-control" placeholder='[{"name": "John Doe", "role": "Developer"}]'>{{ old('team_members', is_array($product->team_members) ? json_encode($product->team_members) : $product->team_members) }}</textarea>
                         </div>
                         <div class="mb-3">
                             <label for="author_commission" class="form-label">Author Commission (%)</label>
                             <input type="number" name="author_commission" id="author_commission" class="form-control" value="{{ old('author_commission', $product->author_commission) }}" min="0" max="100" step="0.01">
                         </div>
                     </div>
                 </div>

                 <div class="card mb-3">
                     <div class="card-header">
                         <h5 class="card-title mb-0">Analytics & SEO</h5>
                     </div>
                     <div class="card-body">
                         <div class="mb-3">
                             <label for="seo_title" class="form-label">SEO Title</label>
                             <input type="text" name="seo_title" id="seo_title" class="form-control" value="{{ old('seo_title', $product->seo_title) }}">
                         </div>
                         <div class="mb-3">
                             <label for="seo_description" class="form-label">SEO Description</label>
                             <textarea name="seo_description" id="seo_description" rows="3" class="form-control">{{ old('seo_description', $product->seo_description) }}</textarea>
                         </div>
                         <div class="mb-3">
                             <label for="seo_keywords" class="form-label">SEO Keywords (comma separated)</label>
                             <input type="text" name="seo_keywords" id="seo_keywords" class="form-control" value="{{ old('seo_keywords', is_array($product->seo_keywords) ? implode(', ', $product->seo_keywords) : $product->seo_keywords) }}">
                         </div>
                         <div class="mb-3">
                             <label class="form-label">OG Image</label>
                             <div id="og-image-dropzone" class="dropzone">
                                 <span>Drag & drop OG image here or click to browse</span>
                             </div>
                             <input type="hidden" name="og_image" id="og-image-input">
                             <div id="og-image-preview" class="mt-2">
                                 @if($product->getFirstMediaUrl('og_image'))
                                     <img src="{{ $product->getFirstMediaUrl('og_image') }}" class="thumbnail-preview img-thumbnail">
                                 @endif
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="d-flex justify-content-between">
                     <button type="submit" class="btn btn-primary">Update Product</button>
                     <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                 </div>
             </form>
         </div>
         <div class="col-md-4">
             <div class="card">
                 <div class="card-header">
                     <h5 class="card-title mb-0">Current Product Info</h5>
                 </div>
                 <div class="card-body">
                     <p><strong>Name:</strong> {{ $product->name }}</p>
                     <p><strong>Price:</strong> ${{ number_format($product->standard_price ?? 0, 2) }}</p>
                     <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                     <p><strong>Status:</strong> {{ $product->is_approved ? 'Approved' : 'Pending' }}</p>
                     @if($product->demo_url)
                         <p><strong>Demo:</strong> <a href="{{ $product->demo_url }}" target="_blank">View Demo</a></p>
                     @endif
                 </div>
             </div>
         </div>
     </div>
 @endsection

 @push('scripts')
 <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.js"></script>
 <script>
     Dropzone.autoDiscover = false;

     // Thumbnail Dropzone
     const thumbnailDropzone = new Dropzone("#thumbnail-dropzone", {
         url: "/admin/products/upload-temp",
         acceptedFiles: "image/*",
         maxFiles: 1,
         maxFilesize: 5,
         addRemoveLinks: true,
         dictDefaultMessage: "Drag & drop thumbnail here or click to browse",
         init: function() {
             this.on("addedfile", async function(file) {
                 const compressedFile = await imageCompression(file, {
                     maxSizeMB: 1,
                     maxWidthOrHeight: 800,
                     useWebWorker: true
                 });
                 this.files[0] = compressedFile;
                 document.getElementById('thumbnail-input').value = compressedFile.name;
                 const reader = new FileReader();
                 reader.onload = function(e) {
                     document.getElementById('thumbnail-preview').innerHTML = `<img src="${e.target.result}" class="thumbnail-preview img-thumbnail">`;
                 };
                 reader.readAsDataURL(compressedFile);
             });
             this.on("removedfile", function() {
                 document.getElementById('thumbnail-input').value = '';
                 document.getElementById('thumbnail-preview').innerHTML = '';
             });
         }
     });

     // Screenshots Dropzone
     const screenshotsDropzone = new Dropzone("#screenshots-dropzone", {
         url: "/admin/products/upload-temp",
         acceptedFiles: "image/*",
         maxFiles: 10,
         maxFilesize: 5,
         addRemoveLinks: true,
         dictDefaultMessage: "Drag & drop screenshots here or click to browse",
         init: function() {
             this.on("addedfile", function(file) {
                 document.getElementById('screenshots-input').value += file.name + ',';
                 const reader = new FileReader();
                 reader.onload = function(e) {
                     document.getElementById('screenshots-preview').innerHTML += `<img src="${e.target.result}" class="thumbnail-preview img-thumbnail">`;
                 };
                 reader.readAsDataURL(file);
             });
             this.on("removedfile", function(file) {
                 const value = document.getElementById('screenshots-input').value;
                 document.getElementById('screenshots-input').value = value.replace(file.name + ',', '');
                 document.getElementById('screenshots-preview').innerHTML = '';
             });
         }
     });

     // Main File Dropzone
     const mainFileDropzone = new Dropzone("#main-file-dropzone", {
         url: "/admin/products/upload-temp",
         acceptedFiles: ".zip,.rar,.7z",
         maxFiles: 1,
         maxFilesize: 100,
         addRemoveLinks: true,
         dictDefaultMessage: "Drag & drop main file here or click to browse",
         init: function() {
             this.on("addedfile", function(file) {
                 document.getElementById('main-file-input').value = file.name;
                 document.getElementById('main-file-preview').innerHTML = `<p>${file.name}</p>`;
             });
             this.on("removedfile", function() {
                 document.getElementById('main-file-input').value = '';
                 document.getElementById('main-file-preview').innerHTML = '';
             });
         }
     });

     // Preview File Dropzone
     const previewFileDropzone = new Dropzone("#preview-file-dropzone", {
         url: "/admin/products/upload-temp",
         acceptedFiles: ".zip,video/*",
         maxFiles: 1,
         maxFilesize: 50,
         addRemoveLinks: true,
         dictDefaultMessage: "Drag & drop preview file here or click to browse",
         init: function() {
             this.on("addedfile", function(file) {
                 document.getElementById('preview-file-input').value = file.name;
                 document.getElementById('preview-file-preview').innerHTML = `<p>${file.name}</p>`;
             });
             this.on("removedfile", function() {
                 document.getElementById('preview-file-input').value = '';
                 document.getElementById('preview-file-preview').innerHTML = '';
             });
         }
     });

     // OG Image Dropzone
     const ogImageDropzone = new Dropzone("#og-image-dropzone", {
         url: "/admin/products/upload-temp",
         acceptedFiles: "image/*",
         maxFiles: 1,
         maxFilesize: 5,
         addRemoveLinks: true,
         dictDefaultMessage: "Drag & drop OG image here or click to browse",
         init: function() {
             this.on("addedfile", function(file) {
                 document.getElementById('og-image-input').value = file.name;
                 const reader = new FileReader();
                 reader.onload = function(e) {
                     document.getElementById('og-image-preview').innerHTML = `<img src="${e.target.result}" class="thumbnail-preview img-thumbnail">`;
                 };
                 reader.readAsDataURL(file);
             });
             this.on("removedfile", function() {
                 document.getElementById('og-image-input').value = '';
                 document.getElementById('og-image-preview').innerHTML = '';
             });
         }
     });

     // Generate slug from name
     document.getElementById('name').addEventListener('input', function() {
         const name = this.value;
         const slug = name.toLowerCase().replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/--+/g, '-');
         document.getElementById('slug').value = slug;
     });

     // Load subcategories based on main category
     document.getElementById('category_id').addEventListener('change', function() {
         const categoryId = this.value;
         const subcategorySelect = document.getElementById('subcategory_id');
         subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
         if (categoryId) {
             fetch(`/admin/categories/${categoryId}/subcategories`)
                 .then(response => response.json())
                 .then(data => {
                     data.forEach(subcategory => {
                         const option = document.createElement('option');
                         option.value = subcategory.id;
                         option.textContent = subcategory.name;
                         if (subcategory.id == {{ $product->subcategory_id ?? 'null' }}) {
                             option.selected = true;
                         }
                         subcategorySelect.appendChild(option);
                     });
                 });
         }
     });

     // Trigger subcategory load on page load if category is selected
     document.addEventListener('DOMContentLoaded', function() {
         const categoryId = document.getElementById('category_id').value;
         if (categoryId) {
             document.getElementById('category_id').dispatchEvent(new Event('change'));
         }
     });
 </script>
 @endpush