@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold">Delicious Burgers & Chicken</h1>
                <p class="lead my-4">Experience the best burgers and chicken in town. Made with fresh ingredients and delivered with love.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-dark btn-lg">
                        <i class="fas fa-utensils me-2"></i> View Menu
                    </a>
                    <a href="#featured" class="btn btn-outline-dark btn-lg">
                        <i class="fas fa-star me-2"></i> Featured Items
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/hero-burger.png') }}" alt="Delicious Burger" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Explore Our Menu</h2>
        <div class="row g-4">
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index', ['category' => 'burger']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-hamburger fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Burgers</h5>
                            <p class="card-text text-muted small">Juicy beef and crispy chicken burgers</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index', ['category' => 'chicken']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-drumstick-bite fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Chicken</h5>
                            <p class="card-text text-muted small">Tender and crispy fried chicken</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index', ['category' => 'sides']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-french-fries fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Sides</h5>
                            <p class="card-text text-muted small">Crispy fries and delicious sides</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-6 col-md-3">
                <a href="{{ route('products.index', ['category' => 'beverage']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-glass-cheers fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">Beverages</h5>
                            <p class="card-text text-muted small">Refreshing drinks and desserts</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5 bg-light" id="featured">
    <div class="container">
        <h2 class="text-center mb-5">Featured Items</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <span class="badge bg-{{ $product->category === 'burger' ? 'danger' : ($product->category === 'chicken' ? 'warning' : ($product->category === 'sides' ? 'info' : 'secondary')) }}">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div><p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-dark">
                                        <i class="fas fa-eye me-1"></i>Details
                                    </a>
                                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="fas fa-cart-plus me-1"></i>Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
          <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-utensils me-2"></i> View All Menu Items
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Customers Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text">
                            "The best burgers I've ever had! The patties are juicy, and the buns are always fresh. 
                            This is my go-to place for a delicious meal."
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="flex-shrink-0">
                                <div class="bg-dark rounded-circle text-white fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">JD</div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">John Doe</h6>
                                <p class="text-muted mb-0 small">Loyal Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="card-text">
                            "The fried chicken is absolutely amazing! Crispy on the outside and tender on the inside. 
                            Their delivery is always prompt and food arrives hot."
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="flex-shrink-0">
                                <div class="bg-dark rounded-circle text-white fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">JS</div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Jane Smith</h6>
                                <p class="text-muted mb-0 small">Food Critic</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3 text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="card-text">
                            "Great variety and quality. The online ordering system is super easy to use, 
                            and the VNPAY integration makes payment a breeze. Will order again!"
                        </p>
                        <div class="d-flex align-items-center mt-4">
                            <div class="flex-shrink-0">
                                <div class="bg-dark rounded-circle text-white fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">RJ</div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Robert Johnson</h6>
                                <p class="text-muted mb-0 small">Regular Customer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2>About Burger Shop</h2>
                <p class="lead">Serving the Best Burgers and Chicken Since 2023</p>
                <p>At Burger Shop, we're passionate about creating mouthwatering burgers and crispy fried chicken using only the freshest ingredients. Our recipes have been perfected over time to ensure that every bite is an explosion of flavor.</p>
                <p>We take pride in our food quality and customer service. Whether you're dining in or ordering online, we aim to provide you with the best experience possible.</p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-dark">
                        <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-dark">
                        <i class="fab fa-instagram fa-2x"></i>
                    </a>
                    <a href="#" class="text-dark">
                        <i class="fab fa-twitter-square fa-2x"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/about-us.jpg') }}" alt="About Burger Shop" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>
@endsection
