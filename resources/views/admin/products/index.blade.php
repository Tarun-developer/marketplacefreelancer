@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Products Management</h4>
                    <div>
                        <button class="btn btn-primary" onclick="exportProducts()">Export Products</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-select" onchange="filterProducts()">
                                <option value="">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="approvalFilter" class="form-select" onchange="filterProducts()">
                                <option value="">All Approval Status</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search products..." onkeyup="filterProducts()">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="productsTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Vendor</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                    <th>Sales</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr data-status="{{ $product->status }}" data-approved="{{ $product->is_approved ? 'approved' : 'pending' }}" data-name="{{ strtolower($product->name) }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->thumbnail)
                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ Str::limit($product->name, 30) }}</h6>
                                                    <small class="text-muted">v{{ $product->version ?? '1.0.0' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->user->name ?? 'N/A' }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($product->standard_price)
                                                <div>Standard: ${{ number_format($product->standard_price, 2) }}</div>
                                            @endif
                                            @if($product->professional_price)
                                                <div>Pro: ${{ number_format($product->professional_price, 2) }}</div>
                                            @endif
                                            @if($product->ultimate_price)
                                                <div>Ultimate: ${{ number_format($product->ultimate_price, 2) }}</div>
                                            @endif
                                            @if($product->is_free)
                                                <span class="badge bg-success">FREE</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-info">{{ ucfirst($product->product_type ?? 'script') }}</span></td>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'active' ? 'success' : ($product->status == 'inactive' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->is_approved)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->sales_count ?? 0 }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                @if($product->is_approved)
                                                    <form action="{{ route('admin.products.reject', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to reject this product?')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-warning">Reject</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.products.approve', $product) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success">Approve</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-3">No products found.</p>
                                            <button class="btn btn-primary" onclick="refreshProducts()">Refresh</button>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterProducts() {
    const statusFilter = document.getElementById('statusFilter').value;
    const approvalFilter = document.getElementById('approvalFilter').value;
    const searchInput = document.getElementById('searchInput').value.toLowerCase();

    const rows = document.querySelectorAll('#productsTable tbody tr');

    rows.forEach(row => {
        if (row.cells.length === 1) return; // Skip empty state row

        const status = row.dataset.status;
        const approved = row.dataset.approved;
        const name = row.dataset.name;

        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesApproval = !approvalFilter || approved === approvalFilter;
        const matchesSearch = !searchInput || name.includes(searchInput);

        if (matchesStatus && matchesApproval && matchesSearch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function resetFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('approvalFilter').value = '';
    document.getElementById('searchInput').value = '';
    filterProducts();
}

function exportProducts() {
    // Implement export functionality
    alert('Export functionality coming soon!');
}

function refreshProducts() {
    location.reload();
}
</script>
@endpush
@endsection