@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
<div class="auth-header">
    <div class="auth-logo">
        <i class="fas fa-shield-alt"></i>
    </div>
    <h1 class="auth-title">Confirm Password</h1>
    <p class="auth-subtitle">This is a secure area. Please confirm your password before continuing.</p>
</div>

<div class="auth-body">
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="form-floating">
            <i class="fas fa-lock input-icon"></i>
            <input id="password" 
                   type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   name="password" 
                   placeholder="Current Password"
                   required 
                   autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-auth-primary">
            <i class="fas fa-check me-2"></i>Confirm Password
        </button>
    </form>
</div>

<div class="auth-footer">
    <p class="text-center">
        <a href="{{ url()->previous() }}" class="auth-link">
            <i class="fas fa-arrow-left me-1"></i>Go Back
        </a>
    </p>
</div>
@endsection
