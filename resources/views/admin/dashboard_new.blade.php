@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Dashboard</h1>
        <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Here's what's happening today.</p>
    </div>
    <div class="text-end">
        <small class="text-muted">Last updated</small><br>
        <strong>{{ now()->format('M d, Y - H:i') }}</strong>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #ff6b00, #ff9500);">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="stats-number">{{ \App\Models\Order::count() }}</div>
                    <div class="stats-label">Total Orders</div>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-success">
                    <i class="fas fa-arrow-up me-1"></i>
                    {{ \App\Models\Order::where('created_at', '>=', now()->subDays(7))->count() }} this week
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #28a745, #34ce57);">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="ms-3 flex-grow-1">                    <div class="stats-number">${{ number_format(\App\Models\Order::where('status', 'delivered')->sum('total_price'), 0) }}</div>
                    <div class="stats-label">Revenue</div>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-success">
                    <i class="fas fa-arrow-up me-1"></i>
                    ${{ number_format(\App\Models\Order::where('status', 'delivered')->where('created_at', '>=', now()->subDays(7))->sum('total_price'), 0) }} this week
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #17a2b8, #20c997);">
                    <i class="fas fa-hamburger"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="stats-number">{{ \App\Models\Product::where('available', true)->count() }}</div>
                    <div class="stats-label">Active Products</div>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-box me-1"></i>
                    {{ \App\Models\Product::count() }} total products
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #6f42c1, #8a63d2);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="ms-3 flex-grow-1">
                    <div class="stats-number">{{ \App\Models\User::count() }}</div>
                    <div class="stats-label">Total Users</div>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-info">
                    <i class="fas fa-crown me-1"></i>
                    {{ \App\Models\User::where('is_admin', true)->count() }} admins
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-xl-4">
        <div class="admin-card h-100">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-lightning-bolt me-2 text-warning"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-eye me-2"></i>View All Orders
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-plus me-2"></i>Add New User
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-secondary">
                        <i class="fas fa-external-link-alt me-2"></i>Visit Store
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="col-xl-8">
        <div class="admin-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2 text-primary"></i>Recent Orders
                </h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                @php
                    $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
                @endphp
                
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <strong class="text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle me-2 text-muted"></i>
                                            {{ $order->user->name ?? 'Guest' }}
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($order->total_amount, 2) }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'confirmed' => 'info',
                                                'preparing' => 'primary',
                                                'ready' => 'success',
                                                'delivered' => 'success',
                                                'cancelled' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $order->created_at->format('M d, H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart text-muted mb-3" style="font-size: 3rem;"></i>
                        <h6 class="text-muted">No orders yet</h6>
                        <p class="text-muted">Orders will appear here once customers start placing them.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mt-4">
    <!-- Order Status Distribution -->
    <div class="col-xl-6">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2 text-info"></i>Order Status Distribution
                </h5>
            </div>
            <div class="card-body">
                @php
                    $orderStatuses = \App\Models\Order::selectRaw('status, COUNT(*) as count')
                        ->groupBy('status')
                        ->pluck('count', 'status')
                        ->toArray();
                    $statusColors = [
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'preparing' => 'primary',
                        'ready' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger'
                    ];
                @endphp
                
                @if(count($orderStatuses) > 0)
                    <div class="row g-3">
                        @foreach($orderStatuses as $status => $count)
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="badge bg-{{ $statusColors[$status] ?? 'secondary' }} rounded-circle p-2">
                                            {{ $count }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ ucfirst($status) }}</h6>
                                        <small class="text-muted">{{ round(($count / array_sum($orderStatuses)) * 100, 1) }}%</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie text-muted mb-3" style="font-size: 3rem;"></i>
                        <h6 class="text-muted">No data available</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Top Products -->
    <div class="col-xl-6">
        <div class="admin-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-star me-2 text-warning"></i>Popular Products
                </h5>
            </div>
            <div class="card-body">
                @php
                    $topProducts = \App\Models\Product::where('available', true)
                        ->take(5)
                        ->get();
                @endphp
                
                @if($topProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($topProducts as $product)
                            <div class="list-group-item border-0 px-0 d-flex align-items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="rounded me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px;">
                                        <i class="fas fa-hamburger text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">${{ number_format($product->price, 2) }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">${{ number_format($product->price, 0) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-hamburger text-muted mb-3" style="font-size: 3rem;"></i>
                        <h6 class="text-muted">No products available</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        // You can add AJAX calls here to refresh stats without page reload
        console.log('Auto-refreshing stats...');
    }, 30000);
    
    // Add smooth animations to stats cards
    $('.stats-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
        $(this).addClass('animate__animated animate__fadeInUp');
    });
});
</script>
@endpush
