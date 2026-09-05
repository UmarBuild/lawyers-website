@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<section class="py-16">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-3xl font-bold text-center text-primary-500 mb-6">Contact Us</h2>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Message</label>
                    <textarea name="message" rows="5" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Send Message
                </button>

            </form>

        </div>
    </div>
</section>

@endsection