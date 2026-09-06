@extends('layouts.app')

@section('title', 'Manage Appointments')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">All Appointments</h1>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Messages</a>
    </div>

    <div class="bg-white border border-gray-100 rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-4 py-3">Lawyer</th>
                    <th class="text-left px-4 py-3">Customer</th>
                    <th class="text-left px-4 py-3">Date & Time</th>
                    <th class="text-left px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $appointment)
                <tr>
                    <td class="px-4 py-3">{{ $appointment->lawyer->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $appointment->customer->name ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $appointment->formattedDateTime() }}</td>
                    <td class="px-4 py-3">
                        @php
                            $styles = ['pending' => 'bg-yellow-100 text-yellow-700','approved' => 'bg-green-100 text-green-700','rejected' => 'bg-red-100 text-red-700','completed' => 'bg-blue-100 text-blue-700'];
                            $style = $styles[$appointment->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $style }}">{{ ucfirst($appointment->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-10 text-center text-gray-400">No appointments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $appointments->links() }}</div>

</section>
@endsection