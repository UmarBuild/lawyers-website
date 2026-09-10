@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')

<section class="py-10">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white border rounded-xl p-8">

            <h2 class="text-xl font-bold text-gray-800 mb-6">Appointment Details</h2>

            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
            @endif

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
                    @elseif($appointment->isCancelled())
                    <span class="text-gray-600 font-medium">Cancelled</span>
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

            @if(auth()->user()->isLawyer() && $appointment->isApproved())
            <div class="mt-6">
                <form action="{{ route('appointments.update-status', $appointment->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600">
                        Mark as Completed
                    </button>
                </form>
            </div>
            @endif

            @if(auth()->user()->isCustomer() && $appointment->isCompleted())
                @if($appointment->isRated())
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-gray-700">Your rating for this appointment:</p>
                    <div class="mt-1 text-yellow-400 text-lg">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $appointment->customer_rating)
                                &#9733;
                            @else
                                <span class="text-gray-200">&#9733;</span>
                            @endif
                        @endfor
                    </div>
                </div>
                @else
                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-sm font-semibold text-gray-700 mb-2">Rate this lawyer:</p>
                    <form action="{{ route('appointments.rate', $appointment->id) }}" method="POST">
                        @csrf
                        <div class="flex gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-400 rating-star">
                                <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                &#9733;
                            </label>
                            @endfor
                        </div>
                        <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm hover:bg-primary-600">
                            Submit Rating
                        </button>
                    </form>
                </div>
                @endif
            @endif

            {{-- Customer can cancel pending/approved appointments --}}
            @if(auth()->user()->isCustomer() && in_array($appointment->status, ['pending', 'approved']))
            <div class="mt-6">
                <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-lg text-sm hover:bg-red-100">
                        Cancel Appointment
                    </button>
                </form>
            </div>
            @endif

            <a href="javascript:history.back()" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-700">← Go Back</a>

        </div>
    </div>
</section>

@push('scripts')
<script>
document.querySelectorAll('.rating-star input').forEach(function(input) {
    input.addEventListener('change', function() {
        var labels = document.querySelectorAll('.rating-star');
        var value  = parseInt(this.value, 10);
        labels.forEach(function(label, idx) {
            var star = label.querySelector('span') || label;
            label.style.color = (idx < value) ? '#facc15' : '#e5e7eb';
        });
    });
});
</script>
@endpush

@endsection