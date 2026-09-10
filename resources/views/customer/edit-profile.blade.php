@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="py-10 px-4 max-w-2xl mx-auto">

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit My Profile</h1>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
        @endif

        <form action="{{ route('customer.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email (read-only)</label>
                <input type="email" value="{{ $user->email }}" disabled
                       class="w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $user->city) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Address</label>
                <textarea name="address" rows="2"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Save Changes
                </button>
                <a href="{{ route('customer.dashboard') }}"
                   class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
            </div>
        </form>

        <hr class="my-6 border-gray-200">

        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800">Password</h3>
                <p class="text-sm text-gray-500">Change your account password.</p>
            </div>
            <a href="{{ route('customer.password.edit') }}"
               class="text-sm bg-gray-100 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Change Password
            </a>
        </div>
    </div>

</section>
@endsection