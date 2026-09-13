@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')

<!-- Executive Welcome Banner -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="text-accent text-xs font-semibold uppercase tracking-wider">Client Portal</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Welcome back, {{ $user->name }}</h1>
            <p class="text-sm sm:text-base text-slate-300 mt-2 max-w-2xl">Here's a quick look at your recent activity, bookings, and account options.</p>
        </div>
        <a href="{{ route('customer.profile.edit') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-amber-400 text-primary-950 font-bold px-5 py-2.5 rounded-xl transition shadow-md self-start md:self-auto">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Profile</span>
        </a>
    </div>
</section>

<section class="py-10 sm:py-12 bg-slate-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
            <a href="{{ route('lawyers.index') }}"
               class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:border-accent/40 transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-2xl shrink-0 group-hover:scale-105 transition">
                    <i class="bi bi-search"></i>
                </div>
                <div>
                    <h3 class="font-bold text-primary-900 text-base">Find a Lawyer</h3>
                    <p class="text-sm text-gray-500">Search by specialization or city</p>
                </div>
            </a>

            <a href="{{ route('my-appointments') }}"
               class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm hover:shadow-xl hover:border-accent/40 transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-2xl shrink-0 group-hover:scale-105 transition">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <div>
                    <h3 class="font-bold text-primary-900 text-base">My Appointments</h3>
                    <p class="text-sm text-gray-500">View all your bookings</p>
                </div>
            </a>
        </div>

        {{-- Recent Appointments --}}
        <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-primary-900 text-white">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <i class="bi bi-clock-history text-accent"></i>
                    Recent Appointments
                </h2>
                <a href="{{ route('my-appointments') }}" class="text-xs text-accent hover:text-amber-300 font-semibold transition">
                    View all <i class="bi bi-arrow-right ml-0.5"></i>
                </a>
            </div>

            @if($appointments->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($appointments as $appointment)
                        <a href="{{ route('appointments.show', $appointment->id) }}"
                           class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-6 py-4 hover:bg-slate-50 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-bold shrink-0">
                                    {{ strtoupper(substr($appointment->lawyer->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $appointment->lawyer->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $appointment->lawyer->specialization }}</p>
                                </div>
                            </div>

                            <div class="text-sm text-gray-500 flex items-center gap-1.5">
                                <i class="bi bi-calendar3 text-accent"></i>
                                {{ $appointment->formattedDateTime() }}
                            </div>

                            @php
                                $statusStyles = [
                                    'pending'   => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'approved'  => 'bg-green-100 text-green-800 border-green-200',
                                    'rejected'  => 'bg-red-100 text-red-800 border-red-200',
                                    'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                ];
                                $style = $statusStyles[$appointment->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $style }} w-fit">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                        <i class="bi bi-calendar-x text-2xl"></i>
                    </div>
                    <p class="text-gray-600 font-semibold">You have no appointments yet.</p>
                    <a href="{{ route('lawyers.index') }}"
                       class="inline-flex items-center gap-2 mt-4 bg-accent hover:bg-amber-400 text-primary-950 font-semibold px-5 py-2 rounded-lg text-sm transition shadow-sm">
                        <i class="bi bi-search"></i>
                        Find a Lawyer
                    </a>
                </div>
            @endif
        </div>

    </div>
</section>

@endsection
