@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<!-- Executive Page Header -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">Account Recovery</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Forgot Password</h1>
        <p class="text-sm sm:text-base text-slate-300 mt-3 max-w-2xl mx-auto">
            Enter your registered email address and we'll send you a secure link to reset your password.
        </p>
    </div>
</section>

<section class="py-10 sm:py-16 bg-slate-50">
    <div class="max-w-2xl mx-auto px-4">

        {{-- Validation errors --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-start gap-2 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill text-red-500 shrink-0 mt-0.5"></i>
            <div>
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 sm:p-10">

            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-xl shadow-sm shrink-0">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-primary-900">Reset Your Password</h2>
                    <p class="text-sm text-gray-500">We'll email you a secure link to set a new password.</p>
                </div>
            </div>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                               placeholder="name@example.com">
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-accent hover:bg-amber-400 text-primary-950 font-bold py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                    <i class="bi bi-send-fill"></i>
                    <span>Send Reset Link</span>
                </button>
            </form>

            <div class="mt-6 p-4 bg-primary-50 border border-primary-100 rounded-xl text-xs text-primary-900 flex items-start gap-2">
                <i class="bi bi-info-circle-fill text-accent mt-0.5 shrink-0"></i>
                <span>Check your inbox (and spam folder) for an email from LawyerConnect.</span>
            </div>

            <p class="text-center text-gray-600 mt-6 text-sm">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-accent font-semibold hover:underline">Login</a>
            </p>
        </div>

    </div>
</section>

@endsection
