@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="py-12 sm:py-16 px-4">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200/80 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[520px]">

            <!-- Left Column: Legal Photography & Brand Card -->
            <div class="lg:col-span-5 relative hidden lg:block bg-primary-950 overflow-hidden">
                <img src="{{ asset('images/auth-legal.jpg') }}" alt="Justice & Legal Counsel" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-900/50 to-primary-950/80"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-between text-white z-10">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-accent text-xs font-semibold border border-white/15 mb-4">
                            <i class="bi bi-shield-lock-fill text-accent"></i>
                            <span>Secure Legal Portal</span>
                        </div>
                        <h2 class="text-2xl font-bold leading-tight text-white">Your Direct Gateway to Verified Counsel</h2>
                        <p class="text-xs text-slate-300 mt-2 leading-relaxed">Access your appointments, case consultation records, and real-time advocate notifications safely.</p>
                    </div>

                    <div class="border-t border-white/10 pt-4 space-y-2 text-xs text-slate-300">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check2-circle text-accent"></i>
                            <span>End-to-end encrypted session</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check2-circle text-accent"></i>
                            <span>Verified Advocate &amp; Client Access</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Login Form -->
            <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center">
                <div class="mb-6">
                    <span class="text-accent text-xs font-semibold uppercase tracking-wider">Welcome Back</span>
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary-900 mt-1">Sign in to your account</h1>
                    <p class="text-sm text-gray-500 mt-1">Enter your credentials to access your dashboard.</p>
                </div>

                {{-- Display all validation/session errors at the top --}}
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-start gap-2 shadow-sm">
                    <i class="bi bi-exclamation-circle-fill text-red-500 shrink-0 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2 shadow-sm">
                    <i class="bi bi-check-circle-fill text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('reset_link'))
                <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-4 py-3 rounded-xl mb-5 text-sm break-all">
                    <p class="font-semibold mb-1">Password Reset Link (local testing mode):</p>
                    <p class="mb-2">Click below to reset your password:</p>
                    <a href="{{ session('reset_link') }}" class="text-primary-900 underline font-semibold">{{ session('reset_link') }}</a>
                </div>
                @endif

                <form action="{{ route('login.authenticate') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold text-sm mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="name@example.com" required>
                        </div>
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-2">
                        <label class="block text-gray-700 font-semibold text-sm mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password"
                                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="Enter your account password" required>
                        </div>
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Forgot-password link --}}
                    <div class="text-right mb-6">
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-primary-700 font-medium hover:text-accent transition">Forgot password?</a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full bg-accent hover:bg-amber-400 text-primary-950 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <i class="bi bi-box-arrow-in-right text-base"></i>
                        <span>Secure Sign In</span>
                    </button>

                </form>

                <p class="text-center text-gray-600 mt-6 text-xs">
                    Don't have an account yet?
                    <a href="{{ route('register') }}" class="text-primary-900 font-bold hover:text-accent transition ml-1">Create Account</a>
                </p>

            </div>
        </div>
    </div>
</section>

@endsection