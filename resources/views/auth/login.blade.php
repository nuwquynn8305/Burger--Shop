@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-hamburger"></i>
    </div>
    <h1 class="auth-title">Welcome Back!</h1>
    <p class="auth-subtitle">Sign in to your Burger Shop account</p>
</div>

<div class="auth-body">
    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
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
                   autofocus 
                   autocomplete="username">
            <label for="email">Email Address</label>
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
                   placeholder="Password"
                   required 
                   autocomplete="current-password">
            <label for="password">Password</label>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Remember me
            </label>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn btn-auth-primary mb-3">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </button>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="text-center">
                <a class="auth-link" href="{{ route('password.request') }}">
                    <i class="fas fa-question-circle me-1"></i>Forgot your password?
                </a>
            </div>
        @endif
    </form>
</div>

<div class="auth-footer">
    <p>Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create one here</a></p>
</div>
@endsection
