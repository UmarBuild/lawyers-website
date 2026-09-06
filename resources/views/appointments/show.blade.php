@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

<section class="py-10">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white border rounded-xl p-8">

            <h2 class="text-xl font-bold text-gray-800 mb-6">Appointment Details</h2>

            <div class="space-y-3 text-sm">
                <p><span class="text-gray-500">Lawyer:</span> <span class="font-medium">{{ $appointment->lawyer->name }}</span></p>
                <p><span class="text-gray-500">Customer:</span> <span class="font-medium">{{ $appointment->customer->name }}</span></p>
                <p><span class="text-gray-500">Date & Time:</span> <span class="font-medium">{{ $appointment->formattedDateTime() }}</span></p>
                <p><span class="text-gray-500">Status:</span>
                    @if($appointment->isPending())
                    <span class="text-yellow-600 font-medium">Pending</span>
                    @elseif($appointment->isApproved())
                    <span class="text-green-600 font-medium">Approved</span>
                    @elseif($appointment->isRejected())
                    <span class="text-red-600 font-medium">Rejected</span>
                    @elseif($appointment->isCompleted())
                    <span class="text-blue-600 font-medium">Completed</span>
                    @endif
                </p>
                @if($appointment->message)
                <p><span class="text-gray-500">Message:</span> {{ $appointment->message }}</p>
                @endif
            </div>

            @if(auth()->user()->isLawyer() && $appointment->isPending())
            <div class="flex gap-2 mt-6">
                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm hover:bg-green-600">Approve</button>
                </form>
                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600">Reject</button>
                </form>
            </div>
            @endif

            <a href="javascript:history.back()" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-700">← Go Back</a>

        </div>
    </div>
</section>

@endsection