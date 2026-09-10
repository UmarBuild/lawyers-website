@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<section class="py-12">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center text-primary-500 mb-2">Forgot Password</h2>
            <p class="text-center text-sm text-gray-500 mb-6">
                Enter your email address and we'll send you a password reset link.
            </p>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                </div>

                <button type="submit"
                        class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center text-gray-600 mt-4 text-sm">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-primary-500 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </div>
</section>
@endsection
