@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<section class="py-10 px-4 max-w-5xl mx-auto">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">My Appointments</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('error') }}
    </div>
    @endif

    @if($appointments->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 divide-y divide-gray-100">
            @foreach($appointments as $appointment)
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 px-6 py-4">
                    <a href="{{ route('appointments.show', $appointment->id) }}"
                       class="flex-1 flex flex-col md:flex-row md:items-center md:justify-between gap-2 hover:bg-gray-50 transition rounded">
                        <div>
                            <p class="font-medium text-gray-800">{{ $appointment->lawyer->name }}</p>
                            <p class="text-sm text-gray-500">{{ $appointment->lawyer->specialization }}</p>
                        </div>
                        <div class="text-sm text-gray-500">{{ $appointment->formattedDateTime() }}</div>
                    </a>

                    <div class="flex items-center gap-3">
                        @php
                            $styles = [
                                'pending'   => 'bg-yellow-100 text-yellow-700',
                                'approved'  => 'bg-green-100 text-green-700',
                                'rejected'  => 'bg-red-100 text-red-700',
                                'completed' => 'bg-blue-100 text-blue-700',
                                'cancelled' => 'bg-gray-200 text-gray-700',
                            ];
                            $style = $styles[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $style }}">
                            {{ ucfirst($appointment->status) }}
                        </span>

                        @if(in_array($appointment->status, ['pending', 'approved']))
                        <form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST"
                              onsubmit="return confirm('Cancel this appointment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-xs font-semibold px-3 py-1 rounded-full bg-red-50 text-red-700 hover:bg-red-100 transition">
                                Cancel
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $appointments->links() }}</div>
    @else
        <div class="bg-white border border-gray-100 rounded-lg p-10 text-center text-gray-400">
            <p>You have no appointments yet.</p>
            <a href="{{ route('lawyers.index') }}" class="inline-block mt-3 text-primary-500 font-medium hover:underline">
                Find a lawyer to get started
            </a>
        </div>
    @endif

</section>
@endsection