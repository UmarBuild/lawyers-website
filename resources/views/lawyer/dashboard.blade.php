@extends('layouts.app')

@section('title', 'Lawyer Dashboard')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $lawyer->name }}</h1>
        <a href="{{ route('lawyer.edit-profile') }}" class="text-sm bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 transition">Edit Profile</a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-primary-500">{{ $totalAppointments }}</p>
            <p class="text-sm text-gray-500">Total</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-yellow-500">{{ $pendingAppointments }}</p>
            <p class="text-sm text-gray-500">Pending</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-green-500">{{ $approvedAppointments }}</p>
            <p class="text-sm text-gray-500">Approved</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $completedAppointments }}</p>
            <p class="text-sm text-gray-500">Completed</p>
        </div>
    </div>

    @if($unreadNotifications->count() > 0)
    <div class="bg-white border border-gray-100 rounded-lg mb-8">
        <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-800">Notifications</div>
        <div class="divide-y divide-gray-100">
            @foreach($unreadNotifications as $notification)
            <div class="px-6 py-3 text-sm text-gray-600">{{ $notification->message }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white border border-gray-100 rounded-lg">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <span class="font-semibold text-gray-800">Recent Appointments</span>
            <a href="{{ route('lawyer.appointments') }}" class="text-sm text-primary-500 hover:underline">Manage All</a>
        </div>

        @if($appointments->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($appointments as $appointment)
            <a href="{{ route('appointments.show', $appointment->id) }}"
               class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 px-6 py-4 hover:bg-gray-50 transition">
                <div>
                    <p class="font-medium text-gray-800">{{ $appointment->customer->name }}</p>
                    <p class="text-sm text-gray-500">{{ $appointment->formattedDateTime() }}</p>
                </div>
                @php
                    $styles = ['pending' => 'bg-yellow-100 text-yellow-700','approved' => 'bg-green-100 text-green-700','rejected' => 'bg-red-100 text-red-700','completed' => 'bg-blue-100 text-blue-700'];
                    $style = $styles[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $style }} w-fit">{{ ucfirst($appointment->status) }}</span>
            </a>
            @endforeach
        </div>
        @else
        <p class="px-6 py-10 text-center text-gray-400">No appointments yet.</p>
        @endif
    </div>

</section>
@endsection