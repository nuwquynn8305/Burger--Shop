@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-envelope-open"></i>
    </div>
    <h1 class="auth-title">Verify Your Email</h1>
    <p class="auth-subtitle">Thanks for signing up! Please verify your email address by clicking the link we sent you.</p>
</div>

<div class="auth-body">
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            A new verification link has been sent to your email address!
        </div>
    @endif

    <div class="d-flex flex-column gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-auth-primary w-100">
                <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sign-out-alt me-2"></i>Log Out
            </button>
        </form>
    </div>
</div>

<div class="auth-footer">
    <p class="text-center">
        Already verified? 
        <a href="{{ route('home') }}" class="auth-link">
            <i class="fas fa-home me-1"></i>Go to Home
        </a>
    </p>
</div>

<style>
.alert {
    background: rgba(40, 167, 69, 0.1);
    border: 2px solid rgba(40, 167, 69, 0.3);
    border-radius: 15px;
    color: #155724;
    padding: 1rem;
    font-weight: 500;
}

.btn-outline-secondary {
    background: transparent;
    border: 2px solid rgba(108, 117, 125, 0.3);
    border-radius: 15px;
    padding: 0.875rem 2rem;
    font-weight: 600;
    color: #6c757d;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
}
</style>
@endsection
