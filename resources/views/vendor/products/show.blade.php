@extends('layouts.vendor')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{ $product->name }}</h4>
                    <div>
                        <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        <a href="{{ route('vendor.products.index') }}" class="btn btn-outline-primary btn-sm">Back to Products</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Product Basics -->
                    <div class="card border-primary mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">🗂️ Product Basics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $product->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Type</th>
                                            <td><span class="badge bg-info">{{ ucfirst($product->product_type) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Version</th>
                                            <td>{{ $product->version }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge bg-{{ $product->status == 'active' ? 'success' : 'warning' }}">{{ ucfirst($product->status) }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Approval</th>
                                            <td><span class="badge bg-{{ $product->is_approved ? 'success' : 'warning' }}">{{ $product->is_approved ? 'Approved' : 'Pending' }}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Downloads</th>
                                            <td>{{ $product->download_count }}</td>
                                        </tr>
                                        <tr>
                                            <th>Views</th>
                                            <td>{{ $product->views_count }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($product->short_description)
                                <h6>Short Description</h6>
                                <p>{{ $product->short_description }}</p>
                            @endif

                            <h6>Description</h6>
                            <div class="border p-3 bg-light">
                                {!! nl2br(e($product->description)) !!}
                            </div>

                            @if($product->tags)
                                <h6 class="mt-3">Tags</h6>
                                <div>
                                    @foreach($product->tags as $tag)
                                        <span class="badge bg-secondary me-1">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pricing & Licensing -->
                    <div class="card border-success mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">💰 Pricing & Licensing</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6>Standard License</h6>
                                    <p class="h4 text-success">${{ number_format($product->standard_price ?? $product->price, 2) }}</p>
                                </div>
                                @if($product->professional_price)
                                    <div class="col-md-4">
                                        <h6>Professional License</h6>
                                        <p class="h4 text-primary">${{ number_format($product->professional_price, 2) }}</p>
                                    </div>
                                @endif
                                @if($product->ultimate_price)
                                    <div class="col-md-4">
                                        <h6>Ultimate License</h6>
                                        <p class="h4 text-warning">${{ number_format($product->ultimate_price, 2) }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($product->discount_percentage > 0)
                                <div class="alert alert-info">
                                    <strong>Discount: {{ $product->discount_percentage }}%</strong>
                                </div>
                            @endif

                            @if($product->is_free)
                                <div class="alert alert-success">
                                    <strong>This product is FREE!</strong>
                                </div>
                            @endif

                            @if($product->money_back_guarantee)
                                <div class="alert alert-info">
                                    <strong>Money Back Guarantee: {{ $product->refund_days }} days</strong>
                                    @if($product->refund_terms)
                                        <br>{{ $product->refund_terms }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Release & Versioning -->
                    <div class="card border-info mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">🧾 Product Release & Versioning</h5>
                        </div>
                        <div class="card-body">
                            @if($product->currentVersion)
                                <div class="alert alert-info">
                                    <h6>Current Active Version: {{ $product->currentVersion->version_number }}</h6>
                                    <p><strong>Released:</strong> {{ $product->currentVersion->release_date->format('M d, Y') }}</p>
                                    <p><strong>File Size:</strong> {{ number_format($product->currentVersion->file_size / 1024 / 1024, 2) }} MB</p>
                                    <p><strong>Downloads:</strong> {{ $product->currentVersion->download_count }}</p>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Feature Updates</th>
                                            <td>
                                                @if($product->feature_update_available)
                                                    <span class="badge bg-success">Available</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Available</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Item Support</th>
                                            <td>
                                                @if($product->item_support_available)
                                                    <span class="badge bg-success">{{ ucfirst($product->support_duration ?? 'Not specified') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Available</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Support Email</th>
                                            <td>{{ $product->support_email ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Versions</th>
                                            <td>{{ $product->versions->count() }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($product->versions->count() > 0)
                                <h6 class="mt-4">Version History</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Version</th>
                                                <th>Release Date</th>
                                                <th>File Size</th>
                                                <th>Downloads</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->versions->take(5) as $version)
                                                <tr>
                                                    <td>{{ $version->version_number }}</td>
                                                    <td>{{ $version->release_date->format('M d, Y') }}</td>
                                                    <td>{{ number_format($version->file_size / 1024 / 1024, 2) }} MB</td>
                                                    <td>{{ $version->download_count }}</td>
                                                    <td>
                                                        @if($version->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-info" onclick="showChangelog('{{ $version->version_number }}', '{{ $version->changelog }}')">View Changelog</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($product->versions->count() > 5)
                                    <p class="text-center mt-2">
                                        <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">View All Versions</a>
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Additional Metadata & SEO -->
                    <div class="card border-warning mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0">📊 Additional Metadata & SEO</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($product->demo_url)
                                        <p><strong>Demo:</strong> <a href="{{ $product->demo_url }}" target="_blank">{{ $product->demo_url }}</a></p>
                                    @endif
                                    @if($product->documentation_url)
                                        <p><strong>Documentation:</strong> <a href="{{ $product->documentation_url }}" target="_blank">{{ $product->documentation_url }}</a></p>
                                    @endif
                                    @if($product->video_preview)
                                        <p><strong>Video Preview:</strong> <a href="{{ $product->video_preview }}" target="_blank">{{ $product->video_preview }}</a></p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($product->compatible_with)
                                        <p><strong>Compatible With:</strong> {{ $product->compatible_with }}</p>
                                    @endif
                                    @if($product->files_included)
                                        <p><strong>Files Included:</strong> {{ implode(', ', $product->files_included) }}</p>
                                    @endif
                                    @if($product->requirements)
                                        <p><strong>Requirements:</strong> {{ $product->requirements }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($product->estimated_delivery_time)
                                <p><strong>Estimated Delivery:</strong> {{ $product->estimated_delivery_time }} days</p>
                            @endif
                        </div>
                    </div>

                    <!-- Seller & Collaboration -->
                    <div class="card border-dark mb-4">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">👥 Seller & Collaboration</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Author:</strong> {{ $product->author_name ?? auth()->user()->name }}</p>
                                    @if($product->team_name)
                                        <p><strong>Team:</strong> {{ $product->team_name }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($product->co_authors && count($product->co_authors) > 0)
                                        <p><strong>Co-Authors:</strong> {{ implode(', ', $product->co_authors) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-outline-primary btn-block">Upload Files</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-secondary btn-block">View Sales</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-info btn-block">Product Analytics</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-success btn-block">View Project</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Changelog Modal -->
<div class="modal fade" id="changelogModal" tabindex="-1" aria-labelledby="changelogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changelogModalLabel">Version Changelog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 id="modalVersionTitle">Version</h6>
                <div id="modalChangelogContent"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function to show changelog modal
    function showChangelog(version, changelog) {
        document.getElementById('modalVersionTitle').textContent = 'Version ' + version;
        document.getElementById('modalChangelogContent').innerHTML = changelog.replace(/\n/g, '<br>');
        new bootstrap.Modal(document.getElementById('changelogModal')).show();
    }
</script>
@endpush
@endsection