@extends('layouts.app')

@section('title', 'Manage Lawyers')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Lawyers</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Messages</a>
    </div>

    <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="px-4 py-2 border rounded-lg flex-1">
        <select name="status" class="px-4 py-2 border rounded-lg">
            <option value="">All</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
        </select>
        <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-600 transition">Filter</button>
    </form>

    <div class="bg-white border border-gray-100 rounded-lg overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left px-4 py-3">Name</th>
                    <th class="text-left px-4 py-3">Specialization</th>
                    <th class="text-left px-4 py-3">City</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($lawyers as $lawyer)
                <tr>
                    <td class="px-4 py-3">{{ $lawyer->name }}</td>
                    <td class="px-4 py-3">{{ $lawyer->specialization }}</td>
                    <td class="px-4 py-3">{{ $lawyer->city }}</td>
                    <td class="px-4 py-3">
                        <span class="{{ $lawyer->is_approved ? 'text-green-500' : 'text-yellow-500' }} font-medium">
                            {{ $lawyer->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 flex gap-2">
                        @if(!$lawyer->is_approved)
                        <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST">
                            @csrf
                            <button class="text-green-600 hover:underline">Approve</button>
                        </form>
                        @else
                        <form action="{{ route('admin.lawyers.reject', $lawyer->id) }}" method="POST">
                            @csrf
                            <button class="text-red-600 hover:underline">Revoke</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400">No lawyers found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $lawyers->appends(request()->query())->links() }}</div>

</section>
@endsection