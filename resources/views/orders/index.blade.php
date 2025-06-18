@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

    <section class="py-5 bg-light">
        <div class="container">
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
              <div class="card border-0 shadow-sm">
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong>#{{ $order->id }}</strong>
                                        </td>
                                        <td>
                                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($order->total_price, 2) }}</strong>
                                        </td>
                                        <td>
                                            {{ $order->payment_method === 'vnpay' ? 'Online Payment (VNPAY)' : 'Cash on Delivery' }}
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill 
                                                {{ $order->status === 'paid' ? 'bg-success' :
                                                ($order->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i> View
                                            </a>
                                            
                                            @if($order->status === 'pending')
                                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="d-inline ms-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                        <i class="fas fa-times me-1"></i> Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-3 d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center p-5">
                        <img src="{{ asset('images/empty-order.svg') }}" alt="No Orders" class="img-fluid mb-3" style="max-height: 200px" onerror="this.onerror=null; this.src='https://via.placeholder.com/200x200?text=No+Orders';">
                        <h4 class="mb-3">You haven't placed any orders yet</h4>
                        <p class="text-muted mb-4">Browse our menu and place your first order now!</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-utensils me-2"></i> Browse Menu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
