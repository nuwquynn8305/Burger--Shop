@extends('layouts.app')

@section('title', 'Order Details')

@section('content')


    <section class="py-5 bg-light">
        <div class="container">
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="fas fa-arrow-left me-2"></i> Back to Orders
                </a>
            </div>
            
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
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <h5 class="card-title mb-0">Order Details</h5>
                            <span class="badge rounded-pill fs-6 px-3 py-2
                                {{ $order->status === 'paid' ? 'bg-success' : 
                                  ($order->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3">Order Items</h6>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;"
                                                                src="{{ $item->product->image_url ?? '/images/default-product.jpg' }}" 
                                                                alt="{{ $item->product->name }}">
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                            <span class="text-muted small">{{ ucfirst($item->product->category) }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>                    </div>

                    @if($order->status === 'pending')
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">Actions</h5>
                                <div class="row">
                                    @if($order->payment_method === 'vnpay')
                                        <div class="col-md-6 mb-3 mb-md-0">
                                            <a href="{{ route('payment.process', $order->id) }}" class="btn btn-primary btn-lg w-100 rounded-pill">
                                                <i class="fas fa-credit-card me-2"></i> Pay Now
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <div class="col-md-{{ $order->payment_method === 'vnpay' ? '6' : '12' }}">
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                class="btn btn-danger btn-lg w-100 rounded-pill"
                                                onclick="return confirm('Are you sure you want to cancel this order?')">
                                                <i class="fas fa-times-circle me-2"></i> Cancel Order
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($order->status === 'paid')
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <div class="mb-3">
                                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="card-title text-success mb-2">Payment Completed</h5>
                                <p class="text-muted mb-3">Your order has been successfully paid and is being processed.</p>
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="fas fa-list me-2"></i> View All Orders
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Order Date:</span>
                                <span>{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Order Time:</span>
                                <span>{{ $order->created_at->format('h:i A') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Payment Method:</span>
                                <span>{{ $order->payment_method === 'vnpay' ? 'Online (VNPAY)' : 'Cash on Delivery' }}</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>$0.00</span>
                            </div>
                            
                            <hr>
                            
                            <div class="d-flex justify-content-between mb-0">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5 text-primary">${{ number_format($order->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
