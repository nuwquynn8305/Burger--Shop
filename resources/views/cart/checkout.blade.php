@extends('layouts.app')

@section('title', 'Checkout')

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

            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="card-title fs-4 fw-bold mb-4">Shipping Information</h2>
                            
                            <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
                                @csrf
                                
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control rounded-pill" id="name" name="name" value="{{ auth()->user()->name }}" readonly>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control rounded-pill" id="email" name="email" value="{{ auth()->user()->email }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="address" class="form-label">Delivery Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your full delivery address" required></textarea>
                                    @error('address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control rounded-pill" id="phone" name="phone" placeholder="Enter your phone number" required>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <h2 class="fs-4 fw-bold mb-3">Payment Method</h2>
                                
                                <div class="mb-4">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cod" value="cod" checked>
                                        <label class="form-check-label d-flex align-items-center" for="payment_method_cod">
                                            <span class="me-2"><i class="fas fa-money-bill text-success"></i></span>
                                            <span>Cash on Delivery (COD)</span>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="payment_method_vnpay" value="vnpay">
                                        <label class="form-check-label d-flex align-items-center" for="payment_method_vnpay">
                                            <span class="me-2"><i class="fas fa-credit-card text-primary"></i></span>
                                            <span>Online Payment (VNPAY)</span>
                                        </label>
                                    </div>
                                    @error('payment_method')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                        <i class="fas fa-check-circle me-2"></i> Place Order
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 100px;">
                        <div class="card-body p-4">
                            <h2 class="card-title fs-4 fw-bold mb-4">Order Summary</h2>
                            
                            <div class="mb-4">
                                @forelse($cart as $id => $item)
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                        <div class="d-flex align-items-center">
                                            @if(stripos($item['image'], 'http') === 0)
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                            @elseif($item['image'])
                                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <img src="https://via.placeholder.com/40x40?text=Food" alt="{{ $item['name'] }}" class="rounded-circle me-3" width="40" height="40">
                                            @endif
                                            <div>
                                                <p class="mb-0 fw-bold">{{ $item['name'] }}</p>
                                                <p class="mb-0 text-muted small">Qty: {{ $item['quantity'] }}</p>
                                            </div>
                                        </div>
                                        <span class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                @empty
                                    <div class="alert alert-warning">
                                        Your cart is empty. Please add items to your cart.
                                    </div>
                                @endforelse
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-bold">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Delivery Fee:</span>
                                <span class="fw-bold">$0.00</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold fs-4 text-primary">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary rounded-pill">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hero-section.small-hero {
            min-height: 30vh;
            background: linear-gradient(135deg, #ff6b00, #ff9500);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 0, 0.25);
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation with visual feedback
            const form = document.getElementById('checkout-form');
            
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        
                        // Highlight required fields
                        const requiredFields = form.querySelectorAll('[required]');
                        requiredFields.forEach(field => {
                            if (!field.value) {
                                field.classList.add('is-invalid');
                                
                                // Add shake animation to invalid fields
                                field.classList.add('animate__animated', 'animate__shakeX');
                                
                                // Remove animation classes after animation ends
                                field.addEventListener('animationend', () => {
                                    field.classList.remove('animate__animated', 'animate__shakeX');
                                });
                                
                                // Remove invalid style when field is focused
                                field.addEventListener('focus', () => {
                                    field.classList.remove('is-invalid');
                                });
                            }
                        });
                    } else {
                        // Show loading state on button
                        const submitButton = form.querySelector('button[type="submit"]');
                        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';
                        submitButton.disabled = true;
                    }
                });
            }
        });
    </script>
@endsection
