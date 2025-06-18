@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Product Details</h1>
        <p class="text-muted mb-0">View detailed information about {{ $product->name }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>Edit Product
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Product Information -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Product Name</label>
                        <div class="fw-semibold fs-5">{{ $product->name }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Category</label>
                        <div>
                            <span class="badge fs-6" style="background: linear-gradient(135deg, {{ 
                                $product->category === 'burger' ? '#dc3545, #c82333' : 
                                ($product->category === 'chicken' ? '#ffc107, #e0a800' : 
                                ($product->category === 'sides' ? '#17a2b8, #138496' : '#6c757d, #5a6268')) 
                            }}); color: white;">
                                <i class="fas fa-{{ 
                                    $product->category === 'burger' ? 'hamburger' : 
                                    ($product->category === 'chicken' ? 'drumstick-bite' : 
                                    ($product->category === 'sides' ? 'utensils' : 'glass-water')) 
                                }} me-2"></i>
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Price</label>
                        <div class="fw-bold text-success fs-4">${{ number_format($product->price, 2) }}</div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold text-muted">Availability</label>
                        <div>
                            @if($product->available)
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>Available
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-times-circle me-1"></i>Unavailable
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-semibold text-muted">Description</label>
                        <div class="bg-light p-3 rounded">{{ $product->description }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">Order Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row g-4 text-center">
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <div class="h4 mb-1 text-primary">{{ $product->orderItems->count() }}</div>
                            <small class="text-muted">Total Orders</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <div class="h4 mb-1 text-success">{{ $product->orderItems->sum('quantity') }}</div>
                            <small class="text-muted">Total Quantity Sold</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <div class="h4 mb-1 text-info">${{ number_format($product->orderItems->sum(function($item) { return $item->quantity * $item->price; }), 2) }}</div>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border rounded p-3">
                            <div class="h4 mb-1 text-warning">{{ $product->created_at->diffForHumans() }}</div>
                            <small class="text-muted">Added</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Product Image -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Product Image</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                     class="img-fluid rounded shadow-sm" style="max-height: 300px;">
            </div>
        </div>

        <!-- Product Actions -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                    
                    @if($product->available)
                        <form action="{{ route('admin.products.update', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="description" value="{{ $product->description }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="category" value="{{ $product->category }}">
                            <input type="hidden" name="available" value="0">
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="fas fa-eye-slash me-2"></i>Mark as Unavailable
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.products.update', $product) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="description" value="{{ $product->description }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="category" value="{{ $product->category }}">
                            <input type="hidden" name="available" value="1">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-eye me-2"></i>Mark as Available
                            </button>
                        </form>
                    @endif
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                    <p class="text-muted">This action cannot be undone and will remove all associated order items.</p>
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
@endsection
