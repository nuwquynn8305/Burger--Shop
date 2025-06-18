@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Products Management</h1>
        <p class="text-muted mb-0">Manage your burger shop products and inventory</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Product
        </a>
        <div class="badge bg-info fs-6">{{ $products->total() }} Total Products</div>
    </div>
</div>

<!-- Filter Card -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold">Search Products</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Product name or description... (works with/without accents)" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="burger" {{ request('category') == 'burger' ? 'selected' : '' }}>Burgers</option>
                    <option value="chicken" {{ request('category') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                    <option value="sides" {{ request('category') == 'sides' ? 'selected' : '' }}>Sides</option>
                    <option value="beverage" {{ request('category') == 'beverage' ? 'selected' : '' }}>Beverages</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Product Info</th>
                    <th>Category</th>
                    <th>Pricing</th>
                    <th>Availability</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>                @forelse ($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">ID: #{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: linear-gradient(135deg, {{ 
                                $product->category === 'burger' ? '#dc3545, #c82333' : 
                                ($product->category === 'chicken' ? '#ffc107, #e0a800' : 
                                ($product->category === 'sides' ? '#17a2b8, #138496' : '#6c757d, #5a6268')) 
                            }}); color: white;">
                                <i class="fas fa-{{ 
                                    $product->category === 'burger' ? 'hamburger' : 
                                    ($product->category === 'chicken' ? 'drumstick-bite' : 
                                    ($product->category === 'sides' ? 'utensils' : 'glass-water')) 
                                }} me-1"></i>
                                {{ ucfirst($product->category) }}
                            </span>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold text-success">${{ number_format($product->price, 2) }}</div>
                                <small class="text-muted">Per item</small>
                            </div>
                        </td>
                        <td>
                            @if($product->available)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>Unavailable
                                </span>
                            @endif
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $product->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View Details"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit Product"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Delete Product"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal{{ $product->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                                <h5>Delete Product</h5>
                                                <p>Are you sure you want to delete <strong>{{ $product->name }}</strong>?</p>
                                                <p class="text-muted">This action cannot be undone.</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash me-2"></i>Delete Product
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                                <h5>No products found</h5>
                                <p class="mb-0">Try adjusting your search criteria or add a new product.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="mt-4">
    @include('admin.partials.pagination', ['paginator' => $products])
</div>
@endif
@endsection
