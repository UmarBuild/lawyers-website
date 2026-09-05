@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')

<section class="py-10">
    <div class="max-w-xl mx-auto px-4">
        <div class="bg-white border rounded-xl p-8">

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Book Appointment</h2>
            <p class="text-gray-500 mb-6">with <span class="text-primary-500 font-medium">{{ $lawyer->name }}</span></p>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf

                <!-- Hidden lawyer ID — user ko nahi dikhana, lekin form me bhejni hai -->
                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                <!-- Date -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Appointment Date</label>
                    <input type="date" name="appointment_date"
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                    <!-- min = kal se start (aaj nahi select kar sakte) -->
                </div>

                <!-- Time -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Appointment Time</label>
                    <input type="time" name="appointment_time"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Message <span class="text-gray-400">(optional)</span></label>
                    <textarea name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" placeholder="Briefly describe your legal issue...">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                    Book Now
                </button>

            </form>

            <a href="{{ route('lawyers.show', $lawyer->id) }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700">← Back to Profile</a>

        </div>
    </div>
</section>

@endsection