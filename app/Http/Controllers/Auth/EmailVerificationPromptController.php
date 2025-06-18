<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        // If user is verified through OTP, allow them to proceed
        if ($request->user()->is_verified) {
            return redirect()->intended(route('dashboard', absolute: false));
        }
        
        // Otherwise redirect to OTP verification page and generate new OTP
        $otpController = new \App\Http\Controllers\Auth\OtpController();
        $otpController->sendOTPForNewUser($request->user());
        return redirect()->route('verification.otp');
    }
}
