@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<section class="py-12">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center text-primary-500 mb-6">Reset Password</h2>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email Address</label>
                    <input type="email" value="{{ $email ?? old('email') }}" disabled
                           class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">New Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                </div>

                <button type="submit"
                        class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Reset Password
                </button>
            </form>

        </div>
    </div>
</section>
@endsection