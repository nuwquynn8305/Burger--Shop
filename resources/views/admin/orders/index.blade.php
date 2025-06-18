@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Orders Management</h1>
        <p class="text-muted mb-0">Manage and track all customer orders</p>
    </div>
    <div class="d-flex gap-2">
        <div class="badge bg-primary fs-6">{{ $orders->total() }} Total Orders</div>
    </div>
</div>

<!-- Filter Card -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Search Orders</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Order ID or customer name..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Payment</label>
                <select name="payment" class="form-select">
                    <option value="">All Methods</option>
                    <option value="vnpay" {{ request('payment') == 'vnpay' ? 'selected' : '' }}>VNPAY</option>
                    <option value="cod" {{ request('payment') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                    <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Highest Amount</option>
                    <option value="lowest" {{ request('sort') == 'lowest' ? 'selected' : '' }}>Lowest Amount</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'payment', 'sort']))
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div><!-- Orders Table -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date & Time</th>
                    <th>Total Amount</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong class="text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user text-muted"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            <strong class="text-success">${{ number_format($order->total_price, 2) }}</strong>
                        </td>
                        <td>
                            @if($order->payment_method == 'vnpay')
                                <span class="badge" style="background: linear-gradient(135deg, #007bff, #0056b3); color: white;">
                                    <i class="fas fa-credit-card me-1"></i>VNPAY
                                </span>
                            @else
                                <span class="badge" style="background: linear-gradient(135deg, #6c757d, #495057); color: white;">
                                    <i class="fas fa-money-bill me-1"></i>COD
                                </span>
                            @endif
                        </td>
                        <td>                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'icon' => 'clock', 'text' => 'Pending'],
                                    'paid' => ['color' => 'success', 'icon' => 'check-circle', 'text' => 'Paid'],
                                    'processing' => ['color' => 'primary', 'icon' => 'cog', 'text' => 'Processing'],
                                    'completed' => ['color' => 'success', 'icon' => 'check-square', 'text' => 'Completed'],
                                    'cancelled' => ['color' => 'danger', 'icon' => 'times-circle', 'text' => 'Cancelled'],
                                    'canceled' => ['color' => 'danger', 'icon' => 'times-circle', 'text' => 'Canceled']
                                ];
                                $config = $statusConfig[$order->status] ?? ['color' => 'secondary', 'icon' => 'question', 'text' => ucfirst($order->status)];
                            @endphp
                            <span class="badge bg-{{ $config['color'] }}">
                                <i class="fas fa-{{ $config['icon'] }} me-1"></i>{{ $config['text'] }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View Details"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit Order"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                  @if(!in_array($order->status, ['completed', 'cancelled', 'canceled']))
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown"
                                            title="Quick Status Update">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($order->status === 'pending')
                                        <li>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="paid">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-check-circle me-2 text-success"></i>Mark as Paid
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        
                                        @if(in_array($order->status, ['paid', 'pending']))
                                        <li>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="processing">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-cog me-2 text-primary"></i>Start Processing
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        
                                        @if($order->status === 'processing')
                                        <li>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-check-square me-2 text-success"></i>Mark as Completed
                                                </button>
                                            </form>
                                        </li>                                        @endif
                                        
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="dropdown-item text-danger" 
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    <i class="fas fa-times-circle me-2"></i>Cancel Order
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-shopping-cart fa-3x mb-3 opacity-50"></i>
                                <h5>No orders found</h5>
                                <p class="mb-0">Try adjusting your search criteria.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($orders->hasPages())
<div class="mt-4">
    @include('admin.partials.pagination', ['paginator' => $orders])
</div>
@endif

<!-- Modals for each order -->
@foreach($orders as $order)
    <!-- Status Modal -->
    <div class="modal fade" id="statusModal{{ $order->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <p>Order #{{ $order->id }} by {{ $order->user->name }}</p>                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add loading state to status update buttons
    $('form button[type="submit"]').click(function() {
        const $btn = $(this);
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');
        $btn.prop('disabled', true);
        
        // Re-enable after 3 seconds in case of error
        setTimeout(function() {
            $btn.html(originalText);
            $btn.prop('disabled', false);
        }, 3000);
    });
    
    // Auto-refresh page every 30 seconds
    setInterval(function() {
        if (!$('.dropdown-menu:visible').length) {
            window.location.reload();
        }
    }, 30000);
});
</script>
@endpush
