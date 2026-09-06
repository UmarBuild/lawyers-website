@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Manage Appointments</h1>
        <a href="{{ route('lawyer.dashboard') }}" class="text-sm text-primary-500 hover:underline">Back to Dashboard</a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    {{-- Status Filter Tabs --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('lawyer.appointments') }}"
           class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-primary-500 text-white' : 'bg-white border border-gray-200 hover:bg-gray-50' }}">
            All
        </a>
        @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'completed' => 'Completed'] as $key => $label)
        <a href="{{ route('lawyer.appointments', ['status' => $key]) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') == $key ? 'bg-primary-500 text-white' : 'bg-white border border-gray-200 hover:bg-gray-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <div class="bg-white border border-gray-100 rounded-lg">
        @if($appointments->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($appointments as $appointment)
            <a href="{{ route('appointments.show', $appointment->id) }}"
               class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-6 py-4 hover:bg-gray-50 transition">
                <div>
                    <p class="font-medium text-gray-800">{{ $appointment->customer->name }}</p>
                    <p class="text-sm text-gray-500">{{ $appointment->formattedDateTime() }}</p>
                    @if($appointment->message)
                    <p class="text-sm text-gray-400 mt-1">"{{ Str::limit($appointment->message, 60) }}"</p>
                    @endif
                </div>

                @php
                    $styles = ['pending' => 'bg-yellow-100 text-yellow-700','approved' => 'bg-green-100 text-green-700','rejected' => 'bg-red-100 text-red-700','completed' => 'bg-blue-100 text-blue-700'];
                    $style = $styles[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $style }} w-fit">{{ ucfirst($appointment->status) }}</span>
            </a>
            @endforeach
        </div>
        <div class="px-6 py-4">{{ $appointments->appends(request()->query())->links() }}</div>
        @else
        <p class="px-6 py-10 text-center text-gray-400">No appointments found.</p>
        @endif
    </div>

</section>
@endsection