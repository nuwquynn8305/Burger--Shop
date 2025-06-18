@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">User Details</h1>
        <p class="text-muted mb-0">Complete information for {{ $user->name }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Users
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <!-- User Profile Card -->
        <div class="admin-card">
            <div class="card-body text-center">
                <div class="mb-4">                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, {{ $user->isAdmin() ? '#dc3545, #c82333' : '#007bff, #0056b3' }});">
                        <i class="fas fa-{{ $user->isAdmin() ? 'crown' : 'user' }} text-white fa-2x"></i>
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-3">                        <span class="badge" style="background: linear-gradient(135deg, {{ $user->isAdmin() ? '#dc3545, #c82333' : '#6f42c1, #8a63d2' }}); color: white;">
                            <i class="fas fa-{{ $user->isAdmin() ? 'crown' : 'user' }} me-1"></i>
                            {{ $user->isAdmin() ? 'Administrator' : 'Customer' }}
                        </span>
                        @if($user->is_verified)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i>Pending
                            </span>
                        @endif
                    </div>
                </div>

                <div class="text-start">
                    <h6 class="fw-semibold mb-3">Account Information</h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small">User ID</div>
                                <div class="fw-semibold">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small">Total Orders</div>
                                <div class="fw-semibold">{{ $user->orders->count() }}</div>
                            </div>
                        </div>                            <div class="col-6">
                                <div class="p-3 bg-light rounded">
                                    <div class="text-muted small">Total Spent</div>
                                    <div class="fw-semibold text-success">${{ number_format($user->orders->where('status', 'delivered')->sum('total_price'), 2) }}</div>
                                </div>
                            </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <div class="text-muted small">Member Since</div>
                                <div class="fw-semibold">{{ $user->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </a>
                    @if(!$user->is_verified)
                    <form action="{{ route('admin.users.toggle-verification', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Mark this user as verified?')">
                            <i class="fas fa-check me-2"></i>Verify User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Order History -->
        <div class="admin-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order History</h5>
                <span class="badge bg-info">{{ $user->orders->count() }} Orders</span>
            </div>
            <div class="card-body p-0">                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Order Details</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders->sortByDesc('created_at') as $order)
                                <tr>
                                    <td>                                        <div>
                                            <div class="fw-semibold">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            <small class="text-success">${{ number_format($order->total_price, 2) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->payment_method == 'vnpay')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-credit-card me-1"></i>VNPay
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-money-bill me-1"></i>Cash
                                            </span>
                                        @endif                                        <div class="small text-muted mt-1">
                                            Payment: {{ ucfirst($order->payment_method) }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'pending' => ['class' => 'warning', 'icon' => 'clock'],
                                                'processing' => ['class' => 'info', 'icon' => 'cog'],
                                                'shipped' => ['class' => 'primary', 'icon' => 'truck'],
                                                'delivered' => ['class' => 'success', 'icon' => 'check-circle'],
                                                'cancelled' => ['class' => 'danger', 'icon' => 'times-circle']
                                            ];
                                            $config = $statusConfig[$order->status] ?? ['class' => 'secondary', 'icon' => 'question'];
                                        @endphp
                                        <span class="badge bg-{{ $config['class'] }}">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-semibold">{{ $order->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           title="View Order Details"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-shopping-cart fa-3x mb-3 opacity-50"></i>
                                            <h5>No orders found</h5>
                                            <p class="mb-0">This user hasn't placed any orders yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
