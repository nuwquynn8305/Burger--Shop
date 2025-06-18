@extends('layouts.app')

@section('title', 'Verify Account')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white text-center py-4">
                    <h4 class="mb-0">Account Verification</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="display-1 text-warning mb-3">
                            <i class="fas fa-lock"></i>
                        </div>
                        <p class="mb-1">We've sent a verification code to your email</p>
                        <p class="text-muted"><strong>{{ substr($email, 0, 3) }}***{{ strstr($email, '@') }}</strong></p>
                    </div>

                    @if (session('status') == 'otp-sent')
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i> A new verification code has been sent to your email.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif                    <form method="POST" action="{{ route('verification.verify-otp') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="form-label">Enter Verification Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg text-center" id="code" name="code" maxlength="6" placeholder="6-digit code" required autofocus>
                                <button type="submit" class="btn btn-primary">Verify</button>
                            </div>
                            <div class="form-text">Please enter the 6-digit code sent to your email.</div>
                        </div>
                    </form><div class="text-center">
                        <p class="mb-2">Didn't receive the code?</p>
                        <form method="POST" action="{{ route('verification.send-otp') }}">
                            @csrf
                            <button type="submit" class="btn btn-link">Resend Verification Code</button>
                        </form>
                        
                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                                <i class="fas fa-sign-out-alt me-1"></i> Cancel and Logout
                            </a>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
