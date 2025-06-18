@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Users Management</h1>
        <p class="text-muted mb-0">Manage user accounts and permissions</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New User
        </a>
        <div class="badge bg-info fs-6">{{ $users->total() }} Total Users</div>
    </div>
</div>

<!-- Filter Card -->
<div class="admin-card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Search Users</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select name="verified" class="form-select">
                    <option value="">All Status</option>
                    <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Verified</option>
                    <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Not Verified</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'role', 'verified']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="admin-table">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>User Info</th>
                    <th>Contact</th>
                    <th>Role & Status</th>
                    <th>Joined Date</th>
                    <th>Orders</th>
                    <th>Actions</th>
                </tr>
            </thead>            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">                                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 45px; height: 45px; background: linear-gradient(135deg, {{ $user->isAdmin() ? '#dc3545, #c82333' : '#007bff, #0056b3' }});">
                                        <i class="fas fa-{{ $user->isAdmin() ? 'crown' : 'user' }} text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <small class="text-muted">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $user->email }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i>Primary contact
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">                                <span class="badge" style="background: linear-gradient(135deg, {{ $user->isAdmin() ? '#dc3545, #c82333' : '#6f42c1, #8a63d2' }}); color: white;">
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
                        </td>
                        <td>
                            <div>
                                <div class="fw-semibold">{{ $user->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>                            @php
                                $orderCount = $user->orders()->count();
                                $totalSpent = $user->orders()->where('status', 'delivered')->sum('total_price');
                            @endphp
                            <div>
                                <div class="fw-semibold">{{ $orderCount }} Orders</div>
                                <small class="text-success">${{ number_format($totalSpent, 2) }} total</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View Details"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit User"
                                   data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if(!$user->is_verified)
                                <form action="{{ route('admin.users.toggle-verification', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-success" 
                                            title="Verify User"
                                            data-bs-toggle="tooltip"
                                            onclick="return confirm('Mark this user as verified?')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                @if($user->id !== auth()->id() && !$user->isAdmin())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete User"
                                            data-bs-toggle="tooltip"
                                            onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                <h5>No users found</h5>
                                <p class="mb-0">Try adjusting your search criteria or add a new user.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($users->hasPages())
<div class="mt-4">
    @include('admin.partials.pagination', ['paginator' => $users])
</div>
@endif
@endsection
