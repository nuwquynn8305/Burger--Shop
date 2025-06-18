@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Order Details</h1>
        <p class="text-muted mb-0">Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }} - {{ $order->created_at->format('M d, Y H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Orders
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Order Items Card -->
        <div class="admin-card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order Items</h5>
                <span class="badge bg-info">{{ $order->orderItems->count() }} Items</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" 
                                                 class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <div class="fw-semibold">{{ $item->product->name }}</div>
                                                <span class="badge badge-sm" style="background: linear-gradient(135deg, {{ 
                                                    $item->product->category === 'burger' ? '#dc3545, #c82333' : 
                                                    ($item->product->category === 'chicken' ? '#ffc107, #e0a800' : 
                                                    ($item->product->category === 'sides' ? '#17a2b8, #138496' : '#6c757d, #5a6268')) 
                                                }}); color: white;">
                                                    {{ ucfirst($item->product->category) }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">${{ number_format($item->price, 2) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-semibold text-success">${{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-end fw-semibold">Total Amount:</td>
                                <td class="text-end">
                                    <span class="h5 mb-0 text-success">${{ number_format($order->total_price, 2) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Summary Card -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Order Status</h5>
            </div>
            <div class="card-body">                @php
                    $statusConfig = [
                        'pending' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Order Received'],
                        'paid' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Payment Received'],
                        'processing' => ['class' => 'info', 'icon' => 'cog', 'text' => 'Being Processed'],
                        'completed' => ['class' => 'success', 'icon' => 'check-square', 'text' => 'Completed'],
                        'cancelled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Cancelled'],
                        'canceled' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Canceled']
                    ];
                    $config = $statusConfig[$order->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => 'Unknown'];
                @endphp
                
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="fas fa-{{ $config['icon'] }} fa-3x text-{{ $config['class'] }}"></i>
                    </div>
                    <span class="badge bg-{{ $config['class'] }} fs-6 px-3 py-2">
                        {{ $config['text'] }}
                    </span>
                </div>
                
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-label fw-semibold">Update Status</label>                    <div class="input-group">
                        <select class="form-select" name="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Payment Method:</span>
                    @if($order->payment_method == 'vnpay')
                        <span class="badge bg-primary">
                            <i class="fas fa-credit-card me-1"></i>VNPay
                        </span>
                    @else
                        <span class="badge bg-secondary">
                            <i class="fas fa-money-bill me-1"></i>Cash on Delivery
                        </span>
                    @endif
                </div>
                
                @if($order->payment_method == 'vnpay' && $order->transaction_id)
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted">Transaction ID:</span>
                    <code class="small">{{ $order->transaction_id }}</code>
                </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="admin-card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 40px; height: 40px; background: linear-gradient(135deg, {{ $order->user->isAdmin() ? '#dc3545, #c82333' : '#007bff, #0056b3' }});">
                        <i class="fas fa-{{ $order->user->isAdmin() ? 'crown' : 'user' }} text-white"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $order->user->name }}</div>
                        <small class="text-muted">{{ $order->user->email }}</small>
                    </div>
                </div>
                
                <div class="border-top pt-3">
                    <div class="row g-2 text-sm">
                        <div class="col-6">
                            <div class="text-muted">Total Orders</div>
                            <div class="fw-semibold">{{ $order->user->orders->count() }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Member Since</div>
                            <div class="fw-semibold">{{ $order->user->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid mt-3">
                    <a href="{{ route('admin.users.show', $order->user) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user me-2"></i>View Customer Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">Delivery Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Delivery Address</label>
                    <div class="fw-semibold">{{ $order->address }}</div>
                </div>
                
                <div class="mb-3">
                    <label class="text-muted small">Phone Number</label>
                    <div class="fw-semibold">{{ $order->phone }}</div>
                </div>
                
                @if($order->notes)
                <div>
                    <label class="text-muted small">Order Notes</label>
                    <div class="fw-semibold">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
