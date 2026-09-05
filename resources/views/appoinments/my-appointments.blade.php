@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')

<section class="py-10">
    <div class="max-w-4xl mx-auto px-4">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">My Appointments</h2>

        @if($appointments->count() > 0)
        <div class="space-y-4">
            @foreach($appointments as $appt)
            <div class="bg-white border rounded-xl p-5 flex items-center justify-between">

                <div>
                    <!-- Lawyer name (via relationship) -->
                    <p class="font-semibold text-gray-800">{{ $appt->lawyer->name }}</p>
                    <p class="text-sm text-primary-500">{{ $appt->lawyer->specialization }}</p>
                    <p class="text-sm text-gray-500">{{ $appt->formattedDateTime() }}</p>
                </div>

                <!-- Status Badge -->
                <div>
                    @if($appt->isPending())
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                    @elseif($appt->isApproved())
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Approved</span>
                    @elseif($appt->isRejected())
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Rejected</span>
                    @elseif($appt->isCompleted())
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Completed</span>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $appointments->links() }}</div>

        @else
        <div class="text-center py-16 text-gray-400">
            <p>No appointments yet.</p>
            <a href="{{ route('lawyers.index') }}" class="text-primary-500 hover:underline mt-2 inline-block">Find a Lawyer</a>
        </div>
        @endif

    </div>
</section>

@endsection