@extends('layouts.app')

@section('title', 'Manage Services')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Services</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
    @endif

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Messages</a>
    </div>

    <form action="{{ route('admin.services.store') }}" method="POST" class="flex gap-3 mb-8">
        @csrf
        <input type="text" name="name" placeholder="New service name (e.g. Family Law)" class="flex-1 px-4 py-2 border rounded-lg" required>
        <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-600 transition">Add</button>
    </form>

    <div class="bg-white border border-gray-100 rounded-lg divide-y divide-gray-100">
        @forelse($services as $service)
        <div class="flex items-center justify-between px-6 py-3">
            <span class="text-gray-700">{{ $service->name }}</span>
            <form action="{{ route('admin.services.delete', $service->id) }}" method="POST" onsubmit="return confirm('Delete this service?');">
                @csrf
                @method('DELETE')
                <button class="text-red-600 hover:underline text-sm">Delete</button>
            </form>
        </div>
        @empty
        <p class="px-6 py-10 text-center text-gray-400">No services added yet.</p>
        @endforelse
    </div>

</section>
@endsection