@extends('layouts.app')

@section('title', 'Homepage Content')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Homepage Content</h1>

    {{-- Admin nav tabs --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Messages</a>
        <a href="{{ route('admin.content') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Content</a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
    @endif

    <form action="{{ route('admin.content.update') }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Hero Section --}}
        <div class="bg-white border border-gray-100 rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-gray-800 mb-4">Home Hero Section</h2>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Hero Title</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Hero Subtitle</label>
                <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>
        </div>

        {{-- Stats Section --}}
        <div class="bg-white border border-gray-100 rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-gray-800 mb-4">Home Stats (3rd card)</h2>
            <p class="text-sm text-gray-500 mb-4">
                The first two cards always show the live lawyer and service counts.
                This card shows a custom label/value pair you can edit below.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Value</label>
                    <input type="text" name="stat_online_value" value="{{ $settings['stat_online_value'] }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Label</label>
                    <input type="text" name="stat_online_label" value="{{ $settings['stat_online_label'] }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>
        </div>

        {{-- Footer Section --}}
        <div class="bg-white border border-gray-100 rounded-lg p-6 mb-6">
            <h2 class="font-semibold text-gray-800 mb-4">Footer Content</h2>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">About Text</label>
                <textarea name="footer_about" rows="3"
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>{{ $settings['footer_about'] }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="footer_email" value="{{ $settings['footer_email'] }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="footer_phone" value="{{ $settings['footer_phone'] }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <input type="text" name="footer_address" value="{{ $settings['footer_address'] }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>
        </div>

        <button type="submit"
                class="bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
            Save Changes
        </button>
    </form>

</section>
@endsection
