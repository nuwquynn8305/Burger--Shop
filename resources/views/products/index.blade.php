@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    
    <section id="menu-grid" class="py-5 bg-light">
        <div class="container py-3">
            <!-- Filter Bar -->
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-body p-4">
                    <form action="{{ route('products.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>                                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                        class="form-control border-start-0 ps-0"
                                        placeholder="Search products... (works with/without accents)">
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-list text-muted"></i>
                                    </span>
                                    <select name="category" id="category" class="form-select border-start-0 ps-0">
                                        <option value="">All Categories</option>
                                        <option value="burger" {{ request('category') == 'burger' ? 'selected' : '' }}>Burgers</option>
                                        <option value="chicken" {{ request('category') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                                        <option value="sides" {{ request('category') == 'sides' ? 'selected' : '' }}>Sides</option>
                                        <option value="drinks" {{ request('category') == 'drinks' ? 'selected' : '' }}>Drinks</option>
                                        <option value="desserts" {{ request('category') == 'desserts' ? 'selected' : '' }}>Desserts</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-sort text-muted"></i>
                                    </span>
                                    <select name="sort" id="sort" class="form-select border-start-0 ps-0">
                                        <option value="">Default Order</option>
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i> Filter Results
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>              <!-- Title bar with category and results info -->
            <div class="row align-items-end mb-4">
                <div class="col-md-6">                    @if(request('search'))
                        <h2 class="section-title mb-0 fw-bold text-primary">Search Results</h2>
                        <p class="text-muted mb-0">Results for: "<span class="fw-medium">{{ request('search') }}</span>"</p>
                    @elseif(request('category'))
                        <h2 class="section-title mb-0 fw-bold text-primary">{{ ucfirst(request('category')) }} Items</h2>
                    @else
                        <h2 class="section-title mb-0 fw-bold text-primary">All Menu Items</h2>
                    @endif
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    @if(request('search') && $products->count() === 0)
                        <p class="text-info mb-0"><i class="fas fa-info-circle me-1"></i>Try searching without accents (e.g., "banh mi" instead of "bánh mỳ")</p>
                    @endif
                </div>
            </div>
            
            <!-- Categories Quick Nav -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('products.index') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    All
                </a>
                <a href="{{ route('products.index', ['category' => 'burger']) }}" class="btn {{ request('category') == 'burger' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    Burgers
                </a>
                <a href="{{ route('products.index', ['category' => 'chicken']) }}" class="btn {{ request('category') == 'chicken' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    Chicken
                </a>
                <a href="{{ route('products.index', ['category' => 'sides']) }}" class="btn {{ request('category') == 'sides' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    Sides
                </a>
                <a href="{{ route('products.index', ['category' => 'drinks']) }}" class="btn {{ request('category') == 'drinks' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    Drinks
                </a>
                <a href="{{ route('products.index', ['category' => 'desserts']) }}" class="btn {{ request('category') == 'desserts' ? 'btn-primary' : 'btn-light' }} rounded-pill">
                    Desserts
                </a>
            </div>              <!-- Products Grid -->
            <div class="row g-4">
                @forelse ($products as $index => $product)
                    <div class="col-6 col-md-4 col-lg-3">                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="position-relative overflow-hidden product-image-container">
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                                    @if(stripos($product->image_url, 'http') === 0)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-img-top product-image">
                                    @elseif($product->image_url)
                                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="card-img-top product-image">
                                    @else
                                        <img src="https://via.placeholder.com/300x200?text=No+Image" alt="{{ $product->name }}" class="card-img-top product-image">
                                    @endif
                                </a><div class="position-absolute top-0 end-0 bg-primary text-white px-2 py-1 m-2 rounded-pill fw-bold shadow-sm price-badge">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                                <div class="position-absolute start-0 bottom-0 end-0 p-3 bg-gradient bg-dark text-white d-flex justify-content-between align-items-center opacity-0 product-actions">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-white fw-bold text-decoration-none hover-underline">
                                        <i class="fas fa-eye me-1"></i> Details
                                    </a>
                                    <button type="button" class="btn btn-sm btn-light rounded-circle pulse-btn" data-bs-toggle="tooltip" title="Add to favorites">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>                            <div class="card-body d-flex flex-column p-3">
                                <h3 class="card-title product-title fw-bold mb-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="card-text product-description text-muted small flex-grow-1 mb-3">{{ Str::limit($product->description, 80) }}</p><form action="{{ route('cart.add') }}" method="POST" class="mt-auto cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill add-to-cart-btn">
                                        <span class="btn-text">
                                            <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                        </span>
                                        <span class="btn-loading d-none">
                                            <i class="fas fa-spinner fa-spin me-2"></i> Adding...
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 my-4 text-center">
                        <div class="card border-0 shadow-sm py-5">
                            <div class="card-body">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h3 class="fs-4 fw-bold text-muted">No products found</h3>
                                <p class="text-muted mb-4">Try adjusting your search or filter criteria</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-redo me-2"></i> Clear all filters
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>              <style>
                /* Product Cards Uniform Sizing */
                .product-card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    min-height: 420px; /* Fixed minimum height for all cards */
                }
                
                .product-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
                }
                
                .product-image-container {
                    height: 200px; /* Fixed height for all product images */
                }
                
                .product-image {
                    height: 100%;
                    width: 100%;
                    object-fit: cover;
                    transition: transform 0.3s ease;
                }
                
                .product-card:hover .product-image {
                    transform: scale(1.05);
                }
                  .product-title {
                    font-size: 1rem;
                    line-height: 1.3;
                    height: 2.6rem; /* Fixed height for titles (2 lines max) */
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                }
                
                .product-title a:hover {
                    color: var(--bs-primary) !important;
                    transition: color 0.3s ease;
                }
                
                .product-description {
                    line-height: 1.4;
                    height: 3.5rem; /* Fixed height for descriptions */
                    overflow: hidden;
                    display: -webkit-box;
                    -webkit-line-clamp: 3;
                    -webkit-box-orient: vertical;
                }
                
                .card-body {
                    min-height: 180px; /* Fixed minimum height for card body */
                }
                  .product-card:hover .product-actions {
                    opacity: 1;
                    transition: opacity 0.3s ease;
                }
                
                .price-badge {
                    font-size: 0.9rem;
                    backdrop-filter: blur(10px);
                    background: rgba(255, 107, 0, 0.9) !important;
                }
                
                .hover-underline:hover {
                    text-decoration: underline !important;
                }
                
                .pulse-btn:hover {
                    animation: pulse 0.6s infinite;
                }
                
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                    100% { transform: scale(1); }
                }
                
                .cart-form button:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
                }
                
                /* Responsive adjustments */
                @media (max-width: 767px) {
                    .product-card {
                        min-height: 380px;
                    }
                    
                    .product-image-container {
                        height: 160px;
                    }
                    
                    .product-title {
                        font-size: 0.9rem;
                        height: 2.4rem;
                    }
                    
                    .product-description {
                        height: 3rem;
                        font-size: 0.8rem;
                    }
                    
                    .card-body {
                        min-height: 160px;
                        padding: 0.75rem;
                    }
                }
                
                @media (min-width: 992px) {
                    .product-card {
                        min-height: 450px;
                    }
                    
                    .product-image-container {
                        height: 220px;
                    }
                    
                    .card-body {
                        min-height: 190px;
                    }
                }
                
                /* Custom Pagination Styling */
                .pagination {
                    --bs-pagination-hover-bg: rgba(255, 107, 0, 0.1);
                    --bs-pagination-focus-bg: rgba(255, 107, 0, 0.1);
                    --bs-pagination-active-bg: var(--primary);
                    --bs-pagination-active-border-color: var(--primary);
                }
                
                .pagination .page-link {
                    color: var(--primary);
                    border: 1px solid #dee2e6;
                    margin: 0 2px;
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 500;
                    transition: all 0.3s ease;
                }
                
                .pagination .page-link:hover {
                    background-color: rgba(255, 107, 0, 0.1);
                    border-color: var(--primary-light);
                }
                
                .pagination .page-item.active .page-link {
                    background-color: var(--primary);
                    border-color: var(--primary);
                    color: #fff;
                    box-shadow: 0 4px 10px rgba(255, 107, 0, 0.2);
                }
                
                .pagination .page-item.disabled .page-link {
                    color: #6c757d;
                    pointer-events: none;
                    background-color: #fff;
                    border-color: #dee2e6;
                }
                  .pagination .page-link:focus {
                    box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
                }
                
                /* Additional styling for pagination-burger class */
                .pagination-burger .page-link {
                    border-radius: 50%;
                    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                }
                
                .pagination-burger .page-item:not(.disabled) .page-link:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 5px 15px rgba(255, 107, 0, 0.2);
                }
                
                .pagination-burger .page-item.active .page-link {
                    transform: scale(1.1);
                }
                
                .pagination-burger .page-item:not(.active):not(.disabled) .page-link:active {
                    transform: scale(0.95);
                }
                
                /* Specific style for page links display on hover */
                .pagination-burger .page-link {
                    position: relative;
                    overflow: hidden;
                    color: #ff6b00;
                }
                
                .pagination-burger .page-link:hover {
                    background-color: rgba(255, 107, 0, 0.2);
                    border-color: rgba(255, 107, 0, 0.5);
                    transform: translateY(-2px);
                    transition: all 0.3s ease;
                }
                
                .pagination-burger .page-link:active {
                    transform: translateY(0);
                }
                
                .pagination-burger .page-item.active .page-link {
                    background-color: #ff6b00;
                    border-color: #ff6b00;
                    color: #fff;
                }
            </style>
            
            <!-- Pagination -->
            <div class="mt-5 mb-4">
                @if ($products->lastPage() > 1)
                <nav aria-label="Product pagination">
                    <ul class="pagination pagination-burger justify-content-center">
                        <!-- Previous Page Link -->
                        <li class="page-item {{ ($products->currentPage() == 1) ? 'disabled' : '' }}">
                            <a class="page-link rounded-start-pill" href="{{ $products->url(1) }}" aria-label="First">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                        </li>
                        <li class="page-item {{ ($products->currentPage() == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                <i class="fas fa-angle-left"></i>
                            </a>
                        </li>
                        
                        <!-- Pagination Elements -->
                        @for ($i = max(1, $products->currentPage() - 1); $i <= min($products->lastPage(), $products->currentPage() + 1); $i++)
                            <li class="page-item {{ ($products->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        
                        <!-- Next Page Link -->
                        <li class="page-item {{ ($products->currentPage() == $products->lastPage()) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                <i class="fas fa-angle-right"></i>
                            </a>
                        </li>
                        <li class="page-item {{ ($products->currentPage() == $products->lastPage()) ? 'disabled' : '' }}">
                            <a class="page-link rounded-end-pill" href="{{ $products->url($products->lastPage()) }}" aria-label="Last">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <p class="text-center text-muted mt-2 small">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items
                </p>
                @endif
            </div>
        </div>
    </section>

    <script>
        // Add to cart loading animation
        document.addEventListener('DOMContentLoaded', function() {
            const cartForms = document.querySelectorAll('.cart-form');
            
            cartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('.add-to-cart-btn');
                    const btnText = button.querySelector('.btn-text');
                    const btnLoading = button.querySelector('.btn-loading');
                    
                    // Show loading state
                    btnText.classList.add('d-none');
                    btnLoading.classList.remove('d-none');
                    button.disabled = true;
                    
                    // Reset after 2 seconds (in case of no redirect)
                    setTimeout(() => {
                        btnText.classList.remove('d-none');
                        btnLoading.classList.add('d-none');
                        button.disabled = false;
                    }, 2000);
                });
            });
            
            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltips.forEach(tooltip => {
                new bootstrap.Tooltip(tooltip);
            });
        });
    </script>
@endsection
