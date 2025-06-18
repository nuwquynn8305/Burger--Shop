@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-key"></i>
    </div>
    <h1 class="auth-title">Forgot Password?</h1>
    <p class="auth-subtitle">No problem! We'll send you a reset link</p>
</div>

<div class="auth-body">
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle me-2"></i>
        Enter your email address and we'll send you a password reset link that will allow you to choose a new one.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-floating">
            <i class="fas fa-envelope input-icon"></i>
            <input id="email" 
                   type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Email Address"
                   required 
                   autofocus>
            <label for="email">Email Address</label>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Send Reset Link Button -->
        <button type="submit" class="btn btn-auth-primary mb-3">
            <i class="fas fa-paper-plane me-2"></i>Send Reset Link
        </button>
    </form>
</div>

<div class="auth-footer">
    <p>Remember your password? <a href="{{ route('login') }}" class="auth-link">Back to login</a></p>
</div>
@endsection
