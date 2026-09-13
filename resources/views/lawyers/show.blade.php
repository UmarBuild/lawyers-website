@extends('layouts.app')

@section('title', $lawyer->name)

@section('content')

<section class="py-10">
    <div class="max-w-4xl mx-auto px-4">

        <!-- Profile Card -->
        <div class="bg-white border rounded-xl p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 text-center sm:text-left">
                <!-- Avatar -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-primary-50 rounded-full flex items-center justify-center text-primary-500 text-2xl sm:text-3xl font-bold flex-shrink-0">
                    {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $lawyer->name }}</h1>
                    <p class="text-primary-500">{{ $lawyer->specialization }}</p>
                    <p class="text-gray-400 text-sm">{{ $lawyer->city }}</p>

                    <!-- Rating -->
                    <div class="flex items-center gap-0.5 mt-2 justify-center sm:justify-start">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $lawyer->rating ? 'text-yellow-400' : 'text-gray-200' }}">&#9733;</span>
                        @endfor
                        <span class="text-sm text-gray-400 ml-1">{{ $lawyer->rating }}/5</span>
                    </div>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t">
                <div>
                    <p class="text-xs text-gray-400 uppercase">Experience</p>
                    <p class="font-semibold text-gray-800">{{ $lawyer->experience_years }} Years</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Fee</p>
                    <p class="font-semibold text-gray-800">Rs. {{ $lawyer->consultation_fee }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Qualification</p>
                    <p class="font-semibold text-gray-800">{{ $lawyer->qualification }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase">Bar Council</p>
                    <p class="font-semibold text-gray-800">{{ $lawyer->bar_council_number }}</p>
                </div>
            </div>

            @if($lawyer->phone)
            <div class="mt-4 text-sm text-gray-600">
                <span class="font-medium">Phone:</span> {{ $lawyer->phone }}
            </div>
            @endif

            @if($lawyer->address)
            <div class="mt-1 text-sm text-gray-600">
                <span class="font-medium">Address:</span> {{ $lawyer->address }}
            </div>
            @endif

            <!-- Available Days -->
            @php($days = $lawyer->getAvailableDays())
            @if(count($days) > 0)
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 mb-1">Available Days:</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($days as $day)
                    <span class="px-3 py-1 bg-primary-50 text-primary-600 rounded-full text-xs">{{ $day }}</span>
                    @endforeach
                </div>
                @if($lawyer->available_time_start && $lawyer->available_time_end)
                <p class="text-sm text-gray-500 mt-2">{{ $lawyer->available_time_start }} - {{ $lawyer->available_time_end }}</p>
                @endif
            </div>
            @endif

            <!-- Book Appointment / View Appointment Button -->
            @auth
                @if(auth()->user()->isCustomer())

                    @if($activeAppointment)
                        {{-- Customer already has an active (pending/approved) appointment with this lawyer --}}
                        <div class="mt-6 p-4 rounded-xl bg-primary-50 border border-primary-100">
                            <p class="text-sm font-semibold text-primary-900 mb-3 flex items-center gap-2">
                                <i class="bi bi-info-circle-fill text-accent"></i>
                                @if($activeAppointment->status === 'pending')
                                    You already have a <span class="text-yellow-700">pending</span> appointment request with this advocate.
                                @else
                                    You already have an <span class="text-green-700">approved</span> appointment with this advocate.
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 mb-3">
                                <i class="bi bi-calendar3"></i>
                                {{ $activeAppointment->formattedDateTime() }}
                            </p>
                            <a href="{{ route('appointments.show', $activeAppointment->id) }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-lg font-semibold text-sm transition shadow-sm">
                                <i class="bi bi-eye"></i>
                                View My Appointment
                            </a>
                        </div>
                    @else
                        {{-- No active appointment — allow fresh booking --}}
                        <a href="{{ route('appointments.create', $lawyer->id) }}"
                           class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary-500 text-white rounded-lg font-semibold hover:bg-primary-600 transition shadow-sm">
                            <i class="bi bi-calendar-plus"></i>
                            Book Appointment
                        </a>
                    @endif

                @endif
            @endauth

            @guest
            <div class="mt-6 p-3 bg-gray-50 rounded-lg text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-primary-500 font-semibold">Login</a> to book an appointment.
            </div>
            @endguest

        </div>
    </div>
</section>

@endsection