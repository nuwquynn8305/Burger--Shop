@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="card-img-top" style="height: 500px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/500x500?text=No+Image" alt="{{ $product->name }}" class="card-img-top" style="height: 500px; object-fit: cover;">
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="h-100">
                <div class="mb-3">
                    <span class="badge bg-{{ $product->category === 'burger' ? 'danger' : ($product->category === 'chicken' ? 'warning' : ($product->category === 'sides' ? 'info' : 'secondary')) }} mb-2">
                        {{ ucfirst($product->category) }}
                    </span>
                    <h1 class="display-5 fw-bold mb-0">{{ $product->name }}</h1>
                </div>

                <div class="mb-4">
                    <span class="display-6 fw-bold text-success">${{ number_format($product->price, 2) }}</span>
                </div>

                @if($product->available)
                    <div class="alert alert-success d-flex align-items-center mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Available now</span>
                    </div>
                @else
                    <div class="alert alert-danger d-flex align-items-center mb-4">
                        <i class="fas fa-times-circle me-2"></i>
                        <span>Currently unavailable</span>
                    </div>
                @endif

                <div class="mb-4">
                    <h5 class="fw-bold mb-3">Description</h5>
                    <p class="text-muted lh-lg">{{ $product->description }}</p>
                </div>

                @if($product->available)
                    <form action="{{ route('cart.add') }}" method="POST" class="border-top pt-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-semibold">Quantity</label>
                                <select name="quantity" id="quantity" class="form-select">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex">
                            <button type="submit" class="btn btn-dark btn-lg flex-grow-1">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Back to Menu
                            </a>
                        </div>
                    </form>
                @else
                    <div class="d-grid">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Menu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    @php
        $relatedProducts = \App\Models\Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('available', true)
            ->take(4)
            ->get();
    @endphp

    @if($relatedProducts->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h3 class="mb-4">You might also like</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative">
                                @if($related->image_url)
                                    <img src="{{ asset($related->image_url) }}" alt="{{ $related->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="{{ $related->name }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded-pill fw-bold shadow-sm">
                                    ${{ number_format($related->price, 2) }}
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2">{{ $related->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1 mb-3">{{ Str::limit($related->description, 80) }}</p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $related->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <form action="{{ route('cart.add') }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $related->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-dark btn-sm w-100">
                                            <i class="fas fa-cart-plus me-1"></i>Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endpush
@endsection
