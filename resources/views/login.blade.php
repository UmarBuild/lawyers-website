@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="py-16">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-3xl font-bold text-center text-primary-500 mb-6">Login</h2>

            {{-- Display all validation/session errors at the top --}}
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500"
                           placeholder="Enter your email" required>
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label class="block text-gray-700 font-medium mb-1">Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500"
                           placeholder="Enter your password" required>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Forgot-password link --}}
                <div class="text-right mb-6">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-primary-500 hover:underline">Forgot password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Login
                </button>

            </form>

            <p class="text-center text-gray-600 mt-4 text-sm">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary-500 font-semibold hover:underline">Register</a>
            </p>

        </div>
    </div>
</section>

@endsection