@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    {{-- Welcome Header --}}
    <div class="bg-primary-500 text-white rounded-lg p-8 mb-8">
        <h1 class="text-2xl md:text-3xl font-bold mb-1">Welcome back, {{ $user->name }} 👋</h1>
        <p class="text-primary-100">Here's a quick look at your recent activity.</p>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-10">
        <a href="{{ route('lawyers.index') }}"
           class="bg-white border border-gray-100 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Find a Lawyer</h3>
                <p class="text-sm text-gray-500">Search by specialization or city</p>
            </div>
        </a>

        <a href="{{ route('my-appointments') }}"
           class="bg-white border border-gray-100 rounded-lg p-6 shadow-sm hover:shadow-md transition flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">My Appointments</h3>
                <p class="text-sm text-gray-500">View all your bookings</p>
            </div>
        </a>
    </div>

    {{-- Recent Appointments --}}
    <div class="bg-white border border-gray-100 rounded-lg shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Recent Appointments</h2>
            <a href="{{ route('my-appointments') }}" class="text-sm text-primary-500 hover:underline">View all</a>
        </div>

        @if($appointments->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($appointments as $appointment)
                    <a href="{{ route('appointments.show', $appointment->id) }}"
                       class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 px-6 py-4 hover:bg-gray-50 transition">
                        <div>
                            <p class="font-medium text-gray-800">{{ $appointment->lawyer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $appointment->lawyer->specialization }}</p>
                        </div>

                        <div class="text-sm text-gray-500">
                            {{ $appointment->formattedDateTime() }}
                        </div>

                        <div>
                            @php
                                $statusStyles = [
                                    'pending'   => 'bg-yellow-100 text-yellow-700',
                                    'approved'  => 'bg-green-100 text-green-700',
                                    'rejected'  => 'bg-red-100 text-red-700',
                                    'completed' => 'bg-blue-100 text-blue-700',
                                ];
                                $style = $statusStyles[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $style }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="px-6 py-10 text-center text-gray-400">
                <p>You have no appointments yet.</p>
                <a href="{{ route('lawyers.index') }}" class="inline-block mt-3 text-primary-500 font-medium hover:underline">
                    Find a lawyer to get started
                </a>
            </div>
        @endif
    </div>

</div>

@endsection