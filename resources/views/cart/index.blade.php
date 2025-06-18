@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

    <section class="py-5 bg-light">
        <div class="container py-3">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(count($cart) > 0)
                <div class="card border-0 shadow-sm mb-5">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="fw-bold py-3">Product</th>
                                    <th scope="col" class="fw-bold py-3">Price</th>
                                    <th scope="col" class="fw-bold py-3">Quantity</th>
                                    <th scope="col" class="fw-bold py-3">Total</th>
                                    <th scope="col" class="fw-bold py-3 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if(stripos($item['image'], 'http') === 0)
                                                    <img src="{{ $item['image'] }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $item['name'] }}">
                                                @elseif($item['image'])
                                                    <img src="{{ asset($item['image']) }}" class="rounded-circle me-3" width="50" height="50" style="object-fit: cover;" alt="{{ $item['name'] }}">
                                                @else
                                                    <img src="https://via.placeholder.com/50x50?text=Food" class="rounded-circle me-3" width="50" height="50" alt="{{ $item['name'] }}">
                                                @endif
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $item['name'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold">${{ number_format($item['price'], 2) }}</span>
                                        </td>
                                        <td>                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <div class="input-group input-group-sm" style="max-width: 120px;">
                                                    <select name="quantity" class="form-select rounded-pill cart-quantity-select">
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                                    <i class="fas fa-trash-alt me-1"></i> Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-lg-4 ms-auto">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="card-title fw-bold mb-3">Order Summary</h5>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Items:</span>
                                    @php
                                        $itemCount = 0;
                                        foreach ($cart as $item) {
                                            $itemCount += $item['quantity'] ?? 1;
                                        }
                                    @endphp
                                    <span class="fw-bold">{{ $itemCount }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <span class="fw-bold">${{ number_format($total, 2) }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Delivery:</span>
                                    <span class="fw-bold">$0.00</span>
                                </div>
                                
                                <hr>
                                
                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fw-bold">Total:</span>
                                    <span class="fw-bold fs-4 text-primary">${{ number_format($total, 2) }}</span>
                                </div>
                                
                                <a href="{{ route('cart.checkout') }}" class="btn btn-primary w-100 rounded-pill mb-3">
                                    <i class="fas fa-credit-card me-2"></i> Proceed to Checkout
                                </a>
                                
                                <div class="d-flex justify-content-between gap-2">
                                    <form action="{{ route('cart.clear') }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-secondary w-100 rounded-pill">
                                            <i class="fas fa-times me-2"></i> Clear Cart
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary flex-grow-1 rounded-pill">
                                        <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm py-5 mb-5 text-center empty-cart">
                    <div class="card-body py-5">                    <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted animate__animated animate__wobble"></i>
                        </div>
                        <h2 class="fw-bold fs-4 mb-3 animate__animated animate__fadeIn">Your cart is empty</h2>
                        <p class="text-muted mb-4 animate__animated animate__fadeIn animate__delay-1s">Looks like you haven't added any items to your cart yet.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 animate__animated animate__fadeIn animate__delay-2s">
                            <i class="fas fa-utensils me-2"></i> Browse Our Menu
                        </a>
                    </div>
                </div>

                <!-- Featured Products Section - Show some recommendations -->
                <div class="my-5">                    <div class="text-center mb-5">
                        <h2 class="section-title fw-bold text-primary">You Might Like</h2>
                        <p class="text-muted">Check out our most popular items</p>
                    </div>
                    
                    <div class="row g-4 justify-content-center">
                        @foreach(\App\Models\Product::where('available', true)->inRandomOrder()->take(3)->get() as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm product-card">
                                    <div class="position-relative overflow-hidden">
                                        @if(stripos($product->image_url, 'http') === 0)
                                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        @elseif($product->image_url)
                                            <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/300x200?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        @endif
                                        <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 m-3 rounded-pill fw-bold shadow-sm">
                                            ${{ number_format($product->price, 2) }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                        <p class="card-text text-muted">{{ Str::limit($product->description, 80) }}</p>
                                        
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                                                <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>    <style>
        :root {
            --primary: #ff6b00;
            --secondary: #212529;
        }
        
        .hero-section.small-hero {
            min-height: 30vh;
            background: linear-gradient(135deg, #ff6b00, #ff9500);
        }
        
        .empty-cart {
            transition: all 0.3s ease;
        }
        
        .empty-cart:hover {
            transform: translateY(-5px);
        }
        
        .empty-cart i.fas {
            color: #ff6b00;
            opacity: 0.3;
            margin-bottom: 1rem;
        }
        
        .empty-cart:hover i.fas {
            animation: bounce 0.7s ease infinite alternate;
        }
        
        @keyframes bounce {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-10px);
            }
        }
        
        .product-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            border: 1px solid var(--primary) !important;
        }
        
        .product-card img {
            transition: transform 0.5s ease;
        }
        
        .product-card:hover img {
            transform: scale(1.1);
        }
        
        /* Cart table styling */
        .table td, .table th {
            vertical-align: middle;
        }
        
        /* Custom form select */
        .form-select.rounded-pill {
            padding-left: 1rem;
            padding-right: 2rem;
        }
    </style>
@endsection
