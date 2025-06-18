<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOTPRequest;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form.
     */
    public function showVerificationForm(Request $request)
    {
        $user = $request->user();
        
        // If user is already verified, redirect to dashboard
        if ($user->is_verified) {
            return redirect()->route('dashboard');
        }
        
        // Generate a new OTP code if none exists
        if (!$user->otpCodes()->exists()) {
            $this->sendOTPForNewUser($user);
        }
        
        return view('auth.verify-otp', [
            'email' => $user->email
        ]);
    }
    
    /**
     * Send OTP code to newly registered user email.
     * This method is specifically for new user registration.
     */
    public function sendOTPForNewUser(User $user)
    {
        // Generate a random 6-digit code
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Delete any existing OTP codes for this user
        OtpCode::where('user_id', $user->id)->delete();
        
        // Create a new OTP code valid for 5 minutes
        OtpCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expired_at' => Carbon::now()->addMinutes(5),
        ]);
        
        // Send email with OTP code
        try {
            $data = [
                'name' => $user->name,
                'code' => $code,
            ];
            
            Mail::send('emails.otp', $data, function($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Your OTP Verification Code');
            });
            
            \Log::info('Email sent successfully to new user: ' . $user->email);
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send email to new user: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send OTP code to user email.
     */
    public function sendOTP(Request $request)
    {
        try {
            $user = $request->user();
            
            // Generate a random 6-digit code
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Delete any existing OTP codes for this user
            OtpCode::where('user_id', $user->id)->delete();
            
            // Create a new OTP code valid for 5 minutes
            OtpCode::create([
                'user_id' => $user->id,
                'code' => $code,
                'expired_at' => Carbon::now()->addMinutes(5),
            ]);
            
            // Send email with OTP code
            $data = [
                'name' => $user->name,
                'code' => $code,
            ];
            
            Mail::send('emails.otp', $data, function($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Your OTP Verification Code');
            });
            
            \Log::info('Email sent successfully to: ' . $user->email);
            return back()->with('status', 'otp-sent');
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage());
            return back()->withErrors(['email' => 'Failed to send OTP code: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Verify the OTP code.
     */
    public function verifyOTP(VerifyOTPRequest $request)
    {
        $user = $request->user();
        $code = $request->input('code');
        
        $otpCode = OtpCode::where('user_id', $user->id)
                         ->where('code', $code)
                         ->first();
        
        if (!$otpCode || $otpCode->isExpired()) {
            return back()->withErrors(['code' => 'Invalid or expired OTP code.']);
        }
        
        // Mark user as verified
        $user->is_verified = true;
        $user->email_verified_at = now(); // Also set email_verified_at for compatibility
        $user->save();
        
        // Delete the OTP code
        $otpCode->delete();
        
        return redirect()->route('home')->with('success', 'Your account has been verified successfully!');
    }
}

