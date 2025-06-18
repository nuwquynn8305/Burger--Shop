@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-hamburger"></i>
    </div>
    <h1 class="auth-title">Join Us!</h1>
    <p class="auth-subtitle">Create your Burger Shop account</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-floating">
            <i class="fas fa-user input-icon"></i>
            <input id="name" 
                   type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Full Name"
                   required 
                   autofocus 
                   autocomplete="name">
            <label for="name">Full Name</label>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

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
                   autocomplete="new-password">
            <label for="password">Password</label>
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
                   placeholder="Confirm Password"
                   required 
                   autocomplete="new-password">
            <label for="password_confirmation">Confirm Password</label>
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn btn-auth-primary mb-3">
            <i class="fas fa-user-plus me-2"></i>Create Account
        </button>

        <!-- Terms Notice -->
        <div class="text-center">
            <small class="text-muted">
                By creating an account, you agree to our 
                <a href="#" class="auth-link">Terms of Service</a> and 
                <a href="#" class="auth-link">Privacy Policy</a>
            </small>
        </div>
    </form>
</div>

<div class="auth-footer">
    <p>Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in here</a></p>
</div>
@endsection
