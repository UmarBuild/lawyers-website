<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    public function showRegister()
    {
        $services = \App\Models\Service::all();
        return view('register', compact('services'));
    }

    public function storeRegistration(Request $request)
    {
        $rules = [
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'role'                => 'required|in:customer,lawyer',
        ];

        if ($request->role === 'lawyer') {
            $rules['phone']               = 'required|string|max:20';
            $rules['city']                = 'required|string|max:100';
            $rules['specialization']      = 'required|string|max:100';
            $rules['qualification']       = 'required|string|max:200';
            $rules['experience_years']    = 'required|integer|min:0|max:50';
            $rules['consultation_fee']    = 'required|integer|min:0';
            $rules['bar_council_number']  = 'required|string|max:100|unique:users,bar_council_number';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only([
            'name', 'email', 'password', 'role',
            'phone', 'city', 'address', 'specialization',
            'qualification', 'experience_years', 'consultation_fee',
            'bar_council_number', 'available_days',
            'available_time_start', 'available_time_end',
        ]);

        $data['password'] = Hash::make($request->password);

        if ($request->role === 'lawyer') {
            $data['is_approved'] = false;
            $data['rating']      = 0.0;

            if (isset($data['available_days']) && is_array($data['available_days'])) {
                $data['available_days'] = json_encode($data['available_days']);
            }
        }

        $user = User::create($data);

        if ($user->isLawyer()) {
            $admin = User::where('role', 'admin')->first();
            if ($admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type'    => 'new_lawyer_registration',
                    'message' => "New lawyer '{$user->name}' has registered and needs approval.",
                    'link'    => '/admin/lawyers',
                    'is_read' => false,
                ]);
            }
        }

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect($this->getDashboardRoute());
        }
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isLawyer() && !$user->isApproved()) {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Your account is pending admin approval.');
            }

            return redirect($this->getDashboardRoute());
        }

        return redirect()->route('login')
            ->with('error', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }

    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // First, verify that the email actually exists in our users table.
        // This prevents us from sending a "reset link sent" message for emails
        // that don't belong to anyone (better UX + slight security hint).
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'We could not find an account with that email address.'])
                ->withInput();
        }

        // Generate the reset token manually so we can BOTH mail it (if a real
        // mailer is configured) AND show it on screen for local testing.
        // This is helpful because the default Laravel .env ships with
        // MAIL_MAILER=log, which means no real email is sent — the link would
        // only appear inside storage/logs/laravel.log and be hard to find.
        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => $token,
                'created_at' => now(),
            ]
        );

        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // Detect whether a real mailer is configured. If MAIL_MAILER is "log"
        // (the default), the email is only written to storage/logs/laravel.log
        // and no real message is delivered — so we also surface the link on
        // the login page for local testing convenience.
        $mailer = config('mail.default');
        $isLogMailer = in_array($mailer, ['log', 'null', 'array']);

        if (!$isLogMailer) {
            // Try to actually send the email through the configured mailer.
            try {
                Mail::raw(
                    "Hello,\n\nYou requested a password reset for your LawyerConnect account.\n\n"
                    . "Click the link below to reset your password:\n"
                    . $resetUrl . "\n\n"
                    . "If you did not request this reset, you can safely ignore this email.\n\n"
                    . "Regards,\nLawyerConnect Team",
                    function ($message) use ($request) {
                        $message->to($request->email)
                                ->subject('LawyerConnect — Password Reset Link');
                    }
                );

                return redirect()->route('login')
                    ->with('success', 'We have emailed you a password reset link. Please check your inbox.');
            } catch (\Throwable $e) {
                // Mailer misconfigured — fall through to the local-testing path.
            }
        }

        // Either the mailer is "log" (no real delivery) or sending failed.
        // Show the reset link on screen so the user can still complete the flow.
        return redirect()->route('login')
            ->with('success', 'Password reset link generated. Email could not be sent (mail not configured) — click the link below to reset your password.')
            ->with('reset_link', $resetUrl);
    }

    public function showResetPassword(Request $request, $token = null)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Validate the token against the password_reset_tokens table.
        // We use our own token validation here (instead of Password::reset)
        // because we generated the token ourselves in sendResetLink().
        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return redirect()->back()
                ->withErrors(['email' => 'This password reset link is invalid or has expired.'])
                ->withInput();
        }

        // Tokens expire after 60 minutes for security.
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('password.request')
                ->withErrors(['email' => 'This password reset link has expired. Please request a new one.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'No account found with that email address.'])
                ->withInput();
        }

        $user->forceFill([
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // Invalidate the token so it can't be reused.
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully! You can now log in with your new password.');
    }

    public function getDashboardRoute()
    {
        $user = Auth::user();
        return match ($user->role) {
            'admin'    => '/admin/dashboard',
            'lawyer'   => '/lawyer/dashboard',
            'customer' => '/customer/dashboard',
        };
    }
}
