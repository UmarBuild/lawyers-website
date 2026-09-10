@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<section class="py-10 px-4 max-w-2xl mx-auto">

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Change Password</h1>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
        @endif

        <form action="{{ route('customer.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Current Password</label>
                <input type="password" name="current_password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">New Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Update Password
                </button>
                <a href="{{ route('customer.profile.edit') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</section>
@endsection