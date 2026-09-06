@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<section class="py-10 px-4 max-w-2xl mx-auto">

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Book Appointment</h1>
        <p class="text-gray-500 mb-6">with <span class="font-semibold text-primary-500">{{ $lawyer->name }}</span> ({{ $lawyer->specialization }})</p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if(!empty($availableDays))
        <div class="bg-primary-50 text-primary-700 text-sm px-4 py-3 rounded-lg mb-4">
            Available days: {{ implode(', ', array_map('ucfirst', $availableDays)) }}
        </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Date</label>
                <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                       min="{{ now()->addDay()->format('Y-m-d') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Time</label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Message (optional)</label>
                <textarea name="message" rows="4" placeholder="Briefly describe your case..."
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">
                Confirm Booking
            </button>
        </form>
    </div>

</section>
@endsection