@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-key"></i>
    </div>
    <h1 class="auth-title">Reset Password</h1>
    <p class="auth-subtitle">Enter your new password to complete the reset</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-floating">
            <i class="fas fa-envelope input-icon"></i>
            <input id="email" 
                   type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   placeholder="Email Address"
                   required 
                   autofocus 
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-floating">
            <i class="fas fa-lock input-icon"></i>
            <input id="password" 
                   type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   name="password" 
                   placeholder="New Password"
                   required 
                   autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-floating">
            <i class="fas fa-lock input-icon"></i>
            <input id="password_confirmation" 
                   type="password" 
                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                   name="password_confirmation" 
                   placeholder="Confirm New Password"
                   required 
                   autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-auth-primary">
            <i class="fas fa-key me-2"></i>Reset Password
        </button>
    </form>
</div>

<div class="auth-footer">
    <p class="text-center">
        Remember your password? 
        <a href="{{ route('login') }}" class="auth-link">
            <i class="fas fa-sign-in-alt me-1"></i>Back to Login
        </a>
    </p>
</div>
@endsection
