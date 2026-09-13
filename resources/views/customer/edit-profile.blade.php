@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<!-- Executive Page Header -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">Account Settings</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Edit My Profile</h1>
        <p class="text-sm sm:text-base text-slate-300 mt-3 max-w-2xl mx-auto">
            Keep your personal information up to date so advocates can reach you easily.
        </p>
    </div>
</section>

<section class="py-10 sm:py-16 bg-slate-50">
    <div class="max-w-2xl mx-auto px-4">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

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
                    <i class="bi bi-person-gear"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold text-primary-900">Personal Information</h2>
                    <p class="text-sm text-gray-500">Update your name, phone, city, and address.</p>
                </div>
            </div>

            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Full Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-person text-sm"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                               placeholder="Your full legal name">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Email (read-only)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="bi bi-envelope text-sm"></i>
                        </span>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Phone</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-telephone text-sm"></i>
                            </span>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="+92 300 1234567">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold text-sm mb-2">City</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-geo-alt text-sm"></i>
                            </span>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" required
                                   class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="e.g. Karachi">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold text-sm mb-2">Address</label>
                    <textarea name="address" rows="3"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                              placeholder="House #, Street, Area">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                            class="flex-1 bg-accent hover:bg-amber-400 text-primary-950 font-bold py-3 rounded-xl transition shadow-md flex items-center justify-center gap-2">
                        <i class="bi bi-save"></i>
                        <span>Save Changes</span>
                    </button>
                    <a href="{{ route('customer.dashboard') }}"
                       class="px-6 py-3 border border-gray-300 rounded-xl font-semibold text-gray-700 hover:bg-gray-50 transition text-center">
                        Cancel
                    </a>
                </div>
            </form>

            <hr class="my-6 border-gray-200">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 bg-primary-50 border border-primary-100 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-900 text-accent flex items-center justify-center shrink-0">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-primary-900 text-sm">Password Security</h3>
                        <p class="text-xs text-gray-500">Change your account password.</p>
                    </div>
                </div>
                <a href="{{ route('customer.password.edit') }}"
                   class="inline-flex items-center gap-1.5 text-sm bg-primary-900 hover:bg-primary-700 text-accent font-semibold px-4 py-2 rounded-lg transition self-start sm:self-auto">
                    <i class="bi bi-key"></i>
                    Change Password
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
