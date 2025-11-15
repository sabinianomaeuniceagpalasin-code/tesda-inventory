<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    // ✅ Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ✅ Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if email is verified
            if (!$user->is_verified) {
                Auth::logout();
                return redirect()->route('waiting.page')->with('error', 'Please verify your email first.');
            }

            // Check if admin has approved the account
            if (!$user->is_approved) {
                Auth::logout();
                return redirect()->route('waiting.page')->with('error', 'Your account is still pending admin approval.');
            }

            // If both verified and approved
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // ✅ Show create account form
    public function showCreateAccount()
    {
        return view('auth.createaccount');
    }

    // ✅ Handle registration (send verification email)
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'role' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Generate 6-digit verification code
        $verificationCode = rand(100000, 999999);

        // Create user (not verified or approved yet)
        $user = User::create([
            'full_name' => $request->full_name,
            'contact_no' => $request->contact_no,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
            'is_verified' => false,
            'is_approved' => false, // default
            'code_expires_at' => now()->addMinutes(10),
        ]);

        // Store email in session for verification form
        session(['email' => $request->email]);

        // Send verification email
        Mail::raw("Your TESDA verification code is: {$verificationCode}. It will expire in 10 minutes.", function ($msg) use ($user) {
            $msg->to($user->email)
                ->subject('TESDA Email Verification Code');
        });

        return redirect()->route('verify.form')
            ->with('success', 'Account created! Please verify your email.');
    }

    // ✅ Show verification page
    public function showVerifyCodeForm()
    {
        return view('auth.verification');
    }

    // ✅ Handle verification code submission
    public function verifyCode(Request $request)
    {
        $email = session('email'); // get stored email
        $enteredCode = implode('', $request->input('code')); // combine the 6 boxes

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found.');
        }

        if ($user->is_verified) {
            return redirect()->route('login')->with('success', 'Your email is already verified.');
        }

        if ($user->verification_code != $enteredCode) {
            return back()->with('error', 'Invalid verification code. Please try again.');
        }

        if (now()->greaterThan($user->code_expires_at)) {
            return back()->with('error', 'Verification code expired. Please request a new one.');
        }

        // ✅ Mark as verified
        $user->update([
            'is_verified' => true,
            'verification_code' => null,
        ]);

        return redirect()->route('waiting.page')->with('success', 'Email verified! Waiting for admin approval.');
    }

    // ✅ Waiting Page (after successful verification or pending approval)
    public function waitingPage()
    {
        return view('waiting');
    }

    // ✅ Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ✅ Dashboard
    public function dashboard()
    {
        return view('dashboard');
    }

    // Show the "enter email" form
public function showForgotPasswordForm()
{
    return view('auth.forgot-password');
}

// Handle sending reset code
public function sendResetCode(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        // It's better UX to show a generic message, but for testing we'll show error
        return back()->withErrors(['email' => 'Email not found.']);
    }

    // Generate 6-digit code and store with expiration
    $code = rand(100000, 999999);
    $user->verification_code = (string)$code;
    $user->code_expires_at = now()->addMinutes(10);
    $user->save();

    // Send email (ensure MAIL_* is configured in .env)
    Mail::raw("Your password reset code is: {$code}. It expires in 10 minutes.", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Password Reset Verification Code');
    });

    // Store email in session to keep track
    session(['reset_email' => $user->email]);

    return redirect()->route('password.verify.form')->with('success', 'Verification code sent to your email.');
}

// Show verify code form
public function showForgotVerifyForm()
{
    $email = session('reset_email');
    if (!$email) {
        return redirect()->route('password.request')->withErrors(['email' => 'Please enter your email first.']);
    }
    return view('auth.forgot-verify', compact('email'));
}

// Handle verify code submission
public function verifyResetCode(Request $request)
{
    // we'll accept code as either a 6-digit single input or six inputs (code[])
    // to keep it simple, expect a single field 'code' (six digits) OR an array code[]
    $request->validate([
        // either code or code.* present; try both
    ]);

    $email = session('reset_email');
    if (!$email) {
        return redirect()->route('password.request')->withErrors(['email' => 'Please enter your email first.']);
    }

    $user = User::where('email', $email)->first();
    if (!$user) {
        return redirect()->route('password.request')->withErrors(['email' => 'Email not found.']);
    }

    // Get entered code (handle input name 'code' or 'code[]')
    $enteredCode = '';
    if ($request->has('code') && is_array($request->input('code'))) {
        $enteredCode = implode('', $request->input('code'));
    } else {
        $enteredCode = $request->input('code') ?? $request->input('verification_code');
    }

    if (!$enteredCode || strlen($enteredCode) != 6) {
        return back()->with('error', 'Please enter the 6-digit code.');
    }

    if ($user->verification_code !== $enteredCode) {
        return back()->with('error', 'Invalid verification code. Please try again.');
    }

    if ($user->code_expires_at && now()->greaterThan($user->code_expires_at)) {
        return back()->with('error', 'Verification code expired. Please request a new one.');
    }

    // Code is valid — mark nothing yet; just allow moving to reset password
    session(['reset_verified_email' => $email]); // flag to allow access to reset form
    return redirect()->route('password.reset.form');
}

// Show create new password form
public function showResetPasswordForm()
{
    $email = session('reset_verified_email');
    if (!$email) {
        return redirect()->route('password.request')->withErrors(['email' => 'Unauthorized access. Please verify code first.']);
    }
    return view('auth.create-new-password', compact('email'));
}

// Handle actual password reset
public function resetPassword(Request $request)
{
    $request->validate([
        'password' => 'required|string|min:6|confirmed',
    ]);

    $email = session('reset_verified_email');
    if (!$email) {
        return redirect()->route('password.request')->withErrors(['email' => 'Unauthorized.']);
    }

    $user = User::where('email', $email)->first();
    if (!$user) {
        return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
    }

    // ✅ Check if new password is the same as the current one
    if (Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Your new password cannot be the same as your current password.']);
    }

    // ✅ Save the new password
    $user->password = Hash::make($request->password);
    $user->verification_code = null;
    $user->code_expires_at = null;
    $user->save();

    // ✅ Clear session reset keys
    session()->forget(['reset_email', 'reset_verified_email']);

    return redirect()->route('password.success');
}

// Show reset success page
public function showResetSuccess()
{
    return view('auth.reset-password-success');
}
}
