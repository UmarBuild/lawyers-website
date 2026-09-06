@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    {{-- Nav Tabs --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Messages</a>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-10">
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-primary-500">{{ $totalCustomers }}</p>
            <p class="text-sm text-gray-500">Customers</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-primary-500">{{ $totalLawyers }}</p>
            <p class="text-sm text-gray-500">Lawyers</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-yellow-500">{{ $pendingLawyers }}</p>
            <p class="text-sm text-gray-500">Pending Approval</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-primary-500">{{ $totalAppointments }}</p>
            <p class="text-sm text-gray-500">Total Appointments</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-yellow-500">{{ $pendingAppointments }}</p>
            <p class="text-sm text-gray-500">Pending Appointments</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-lg p-5 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $completedAppointments }}</p>
            <p class="text-sm text-gray-500">Completed</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Recent Appointments --}}
        <div class="bg-white border border-gray-100 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-800">Recent Appointments</div>
            <div class="divide-y divide-gray-100">
                @forelse($recentAppointments as $appointment)
                <div class="px-6 py-3 text-sm">
                    <p class="text-gray-700">{{ $appointment->formattedDateTime() }}</p>
                    <p class="text-gray-400">{{ ucfirst($appointment->status) }}</p>
                </div>
                @empty
                <p class="px-6 py-6 text-center text-gray-400 text-sm">No appointments yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Lawyers --}}
        <div class="bg-white border border-gray-100 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-100 font-semibold text-gray-800">Recent Lawyers</div>
            <div class="divide-y divide-gray-100">
                @forelse($recentLawyers as $lawyer)
                <div class="px-6 py-3 text-sm flex items-center justify-between">
                    <span class="text-gray-700">{{ $lawyer->name }}</span>
                    <span class="{{ $lawyer->is_approved ? 'text-green-500' : 'text-yellow-500' }}">
                        {{ $lawyer->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                </div>
                @empty
                <p class="px-6 py-6 text-center text-gray-400 text-sm">No lawyers yet.</p>
                @endforelse
            </div>
        </div>
    </div>

</section>
@endsection