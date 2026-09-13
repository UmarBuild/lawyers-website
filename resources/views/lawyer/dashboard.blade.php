@extends('layouts.app')

@section('title', 'Lawyer Dashboard')

@section('content')

<!-- Executive Welcome Banner -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="text-accent text-xs font-semibold uppercase tracking-wider">Advocate Portal</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Welcome, {{ $lawyer->name }}</h1>
            <p class="text-sm sm:text-base text-slate-300 mt-2 max-w-2xl">Manage your appointments, profile, and client bookings from one place.</p>
        </div>
        <a href="{{ route('lawyer.edit-profile') }}"
           class="inline-flex items-center gap-2 bg-accent hover:bg-amber-400 text-primary-950 font-bold px-5 py-2.5 rounded-xl transition shadow-md self-start md:self-auto">
            <i class="bi bi-pencil-square"></i>
            <span>Edit Profile</span>
        </a>
    </div>
</section>

<section class="py-10 sm:py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2 shadow-sm">
            <i class="bi bi-check-circle-fill text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-primary-900 text-accent flex items-center justify-center text-lg mb-3">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <p class="text-3xl font-extrabold text-primary-900">{{ $totalAppointments }}</p>
                <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Total</p>
            </div>
            <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 text-yellow-700 flex items-center justify-center text-lg mb-3">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <p class="text-3xl font-extrabold text-yellow-600">{{ $pendingAppointments }}</p>
                <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Pending</p>
            </div>
            <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center text-lg mb-3">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <p class="text-3xl font-extrabold text-green-600">{{ $approvedAppointments }}</p>
                <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Approved</p>
            </div>
            <div class="bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition">
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-lg mb-3">
                    <i class="bi bi-calendar-check-fill"></i>
                </div>
                <p class="text-3xl font-extrabold text-blue-600">{{ $completedAppointments }}</p>
                <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Completed</p>
            </div>
        </div>

        @if($unreadNotifications->count() > 0)
        <div class="bg-white border border-gray-200/80 rounded-2xl mb-8 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 bg-primary-900 text-white font-semibold flex items-center gap-2">
                <i class="bi bi-bell-fill text-accent"></i>
                <span>Notifications</span>
                <span class="ml-auto bg-accent/20 text-accent text-[11px] font-semibold px-2 py-0.5 rounded-full border border-accent/40">
                    {{ $unreadNotifications->count() }} new
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach($unreadNotifications as $notification)
                <a href="{{ $notification->link ?: '#' }}"
                   class="flex items-start gap-3 px-6 py-3.5 hover:bg-slate-50 transition">
                    <div class="w-8 h-8 rounded-full bg-primary-900 text-accent flex items-center justify-center text-sm shrink-0">
                        <i class="bi {{ $notification->iconClass() }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-700 font-medium leading-relaxed">{{ $notification->message }}</p>
                        <span class="text-xs text-gray-400 mt-0.5 block">
                            <i class="bi bi-clock"></i> {{ $notification->timeAgo() }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
            <div class="p-3 bg-gray-50 text-center border-t border-gray-100">
                <a href="{{ route('notifications.index') }}" class="text-xs text-primary-700 hover:text-primary-900 font-semibold transition">
                    View all notifications <i class="bi bi-arrow-right ml-0.5"></i>
                </a>
            </div>
        </div>
        @endif

        {{-- Recent Appointments --}}
        <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-primary-900 text-white">
                <span class="font-bold text-base flex items-center gap-2">
                    <i class="bi bi-clock-history text-accent"></i>
                    Recent Appointments
                </span>
                <a href="{{ route('lawyer.appointments') }}" class="text-xs text-accent hover:text-amber-300 font-semibold transition">
                    Manage All <i class="bi bi-arrow-right ml-0.5"></i>
                </a>
            </div>

            @if($appointments->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($appointments as $appointment)
                <a href="{{ route('appointments.show', $appointment->id) }}"
                   class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-6 py-4 hover:bg-slate-50 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-primary-50 text-primary-700 flex items-center justify-center font-bold shrink-0">
                            {{ strtoupper(substr($appointment->customer->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $appointment->customer->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $appointment->formattedDateTime() }}</p>
                        </div>
                    </div>
                    @php
                        $styles = [
                            'pending'   => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'approved'  => 'bg-green-100 text-green-800 border-green-200',
                            'rejected'  => 'bg-red-100 text-red-800 border-red-200',
                            'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
                        ];
                        $style = $styles[$appointment->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                    @endphp
                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $style }} w-fit">{{ ucfirst($appointment->status) }}</span>
                </a>
                @endforeach
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                    <i class="bi bi-calendar-x text-2xl"></i>
                </div>
                <p class="text-gray-600 font-semibold">No appointments yet.</p>
                <p class="text-sm text-gray-500 mt-1">New client booking requests will appear here.</p>
            </div>
            @endif
        </div>

    </div>
</section>

@endsection