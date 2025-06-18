@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<!-- Profile Content -->
<div class="container py-5">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Navigation -->
        <div class="col-lg-3 mb-4">
            <div class="card profile-nav-card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="profile-avatar">
                            <i class="fas fa-user-circle text-primary"></i>
                        </div>
                        <h5 class="mt-3 mb-1">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->email }}</p>
                        @if($user->isAdmin())
                            <span class="badge bg-primary">
                                <i class="fas fa-crown me-1"></i>Admin
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-user me-1"></i>Customer
                            </span>
                        @endif
                    </div>
                    
                    <div class="nav flex-column nav-pills profile-nav" role="tablist">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#profile-info">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#change-password">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#account-settings">
                            <i class="fas fa-cog me-2"></i>Account Settings
                        </button>
                        <a href="{{ route('orders.index') }}" class="nav-link">
                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                        </a>
                        @if($user->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="col-lg-9">
            <div class="tab-content">
                <!-- Personal Information Tab -->
                <div class="tab-pane fade show active" id="profile-info">
                    <div class="card profile-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user me-1"></i>Full Name
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i>Email Address
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-calendar me-1"></i>Member Since
                                        </label>
                                        <input type="text" class="form-control" 
                                               value="{{ $user->created_at->format('F j, Y') }}" readonly>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-shield-alt me-1"></i>Account Status
                                        </label>
                                        <input type="text" class="form-control" 
                                               value="{{ $user->is_verified ? 'Verified' : 'Unverified' }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Password Tab -->
                <div class="tab-pane fade" id="change-password">
                    <div class="card profile-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-key me-2"></i>Change Password
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($errors->updatePassword->any())
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    @foreach($errors->updatePassword->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif

                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PATCH')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">
                                        <i class="fas fa-lock me-1"></i>Current Password
                                    </label>
                                    <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                    @error('current_password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-key me-1"></i>New Password
                                    </label>
                                    <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                           id="password" name="password" required>
                                    @error('password', 'updatePassword')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-key me-1"></i>Confirm New Password
                                    </label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation" required>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-shield-alt me-2"></i>Change Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Account Settings Tab -->
                <div class="tab-pane fade" id="account-settings">
                    <div class="card profile-content-card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="fas fa-cog me-2"></i>Account Settings
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Account Statistics</h6>
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <div class="stat-icon">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5>{{ $user->orders->count() }}</h5>
                                                <p>Total Orders</p>
                                            </div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-icon">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="stat-content">
                                                <h5>${{ number_format($user->orders->sum('total_amount'), 2) }}</h5>
                                                <p>Total Spent</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">Danger Zone</h6>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Delete Account</strong><br>
                                        Once you delete your account, all of its resources and data will be permanently deleted.
                                    </div>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                        <i class="fas fa-trash me-2"></i>Delete Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('DELETE')
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            Enter your password to confirm:
                        </label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .profile-nav-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 15px;
    }
    
    .profile-content-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 15px;
    }
    
    .profile-avatar i {
        font-size: 4rem;
    }
    
    .profile-nav .nav-link {
        border-radius: 10px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
        color: #6c757d;
        text-decoration: none;
    }
    
    .profile-nav .nav-link:hover,
    .profile-nav .nav-link.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        transform: translateX(5px);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .stat-icon i {
        color: white;
        font-size: 1.5rem;
    }
    
    .stat-content h5 {
        margin: 0;
        font-weight: 600;
        color: var(--primary);
    }
    
    .stat-content p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 0, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
        
        // Handle tab switching with URL hash
        if (window.location.hash) {
            $('.nav-link[data-bs-target="' + window.location.hash + '"]').tab('show');
        }
        
        $('.nav-link[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
            window.location.hash = $(e.target).attr('data-bs-target');
        });
    });
</script>
@endpush
@endsection
