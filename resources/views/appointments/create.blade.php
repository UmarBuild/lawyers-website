@extends('layouts.app')

@section('title', 'Book Appointment')

@section('content')
<section class="py-12 px-4 max-w-5xl mx-auto">

    <div class="mb-8 text-center sm:text-left">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">Schedule Consultation</span>
        <h1 class="text-3xl font-extrabold text-primary-900 mt-1">Book an Appointment</h1>
        <p class="text-sm text-gray-500">Secure an exclusive consultation session with a verified legal advocate.</p>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-6 text-sm flex items-start gap-2 shadow-sm">
        <i class="bi bi-exclamation-circle-fill text-red-500 shrink-0 mt-0.5"></i>
        <div>
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-6 text-sm flex items-start gap-2 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill text-red-500 shrink-0 mt-0.5"></i>
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Left Column: Advocate Overview & Consultation Details -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="relative h-44 overflow-hidden bg-primary-900">
                    <img src="{{ asset('images/hero-scales.jpg') }}" alt="Legal Consultation" class="w-full h-full object-cover opacity-80">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-900/40 to-transparent"></div>
                    <div class="absolute bottom-3 left-4 text-white">
                        <span class="bg-accent/90 text-primary-950 text-[11px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Verified Advocate</span>
                        <h3 class="text-lg font-bold mt-1 text-white">{{ $lawyer->name }}</h3>
                        <p class="text-xs text-slate-300">{{ $lawyer->specialization }} Advocate</p>
                    </div>
                </div>

                <div class="p-5 space-y-3 text-sm">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <span class="text-gray-500">Consultation Fee</span>
                        <span class="font-bold text-primary-900 text-base">Rs. {{ number_format($lawyer->consultation_fee) }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <span class="text-gray-500">Location</span>
                        <span class="font-medium text-gray-800">{{ $lawyer->city }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <span class="text-gray-500">Experience</span>
                        <span class="font-medium text-gray-800">{{ $lawyer->experience_years }} Years</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500">Bar Council Reg</span>
                        <span class="font-medium text-gray-800">{{ $lawyer->bar_council_number ?? 'Verified' }}</span>
                    </div>
                </div>
            </div>

            <!-- Availability Schedule Card -->
            <div class="bg-primary-50 border border-primary-100 rounded-2xl p-5 text-primary-950 space-y-3 shadow-sm">
                <h4 class="font-bold text-sm text-primary-900 flex items-center gap-2">
                    <i class="bi bi-clock-history text-accent"></i>
                    <span>Consultation Hours &amp; Days</span>
                </h4>
                
                <div class="text-xs space-y-2 text-gray-700">
                    <div class="flex items-start gap-2">
                        <i class="bi bi-calendar-check text-primary-600 mt-0.5"></i>
                        <div>
                            <span class="font-semibold text-gray-900">Available Days:</span>
                            <p class="text-gray-600 mt-0.5">{{ !empty($availableDays) ? implode(', ', array_map('ucfirst', $availableDays)) : 'Monday to Friday' }}</p>
                        </div>
                    </div>
                    @if($lawyer->available_time_start && $lawyer->available_time_end)
                    <div class="flex items-start gap-2">
                        <i class="bi bi-alarm text-primary-600 mt-0.5"></i>
                        <div>
                            <span class="font-semibold text-gray-900">Working Hours:</span>
                            <p class="text-gray-600 mt-0.5">{{ date('h:i A', strtotime($lawyer->available_time_start)) }} &ndash; {{ date('h:i A', strtotime($lawyer->available_time_end)) }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Booking Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="bi bi-calendar-plus text-accent"></i>
                    <span>Select Appointment Slot</span>
                </h3>

                <form id="appointment-form" action="{{ route('appointments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Preferred Date</label>
                        <div class="relative">
                            <input type="date" name="appointment_date" value="{{ old('appointment_date') }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm" required>
                        </div>
                        <p class="text-[11px] text-gray-600 mt-1.5">Appointments must be scheduled at least 1 day in advance.</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Preferred Time</label>
                        <div class="relative">
                            <input type="time" name="appointment_time" value="{{ old('appointment_time') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm" required>
                        </div>
                        <p class="text-[11px] text-gray-600 mt-1.5">Please choose a time within the advocate's available consultation hours.</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Case Summary / Message <span class="text-gray-600 font-normal">(optional)</span></label>
                        <textarea name="message" rows="4" placeholder="Briefly describe your legal inquiry or case details..."
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm">{{ old('message') }}</textarea>
                    </div>

                    <button id="book-submit-btn" type="submit" class="w-full bg-accent hover:bg-amber-400 text-primary-950 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <i class="bi bi-shield-check text-base"></i>
                        <span>Confirm Appointment Request</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('appointment-form');
    const submitBtn = document.getElementById('book-submit-btn');

    if (bookingForm && submitBtn) {
        bookingForm.addEventListener('submit', function(e) {
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            // Instantly disable button to prevent double-click duplicate requests
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin text-base"></i><span>Sending Request...</span>';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        });
    }
});
</script>
@endpush

@endsection