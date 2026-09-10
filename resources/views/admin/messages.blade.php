@extends('layouts.app')

@section('title', 'Contact Messages')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Contact Messages</h1>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Dashboard</a>
        <a href="{{ route('admin.lawyers') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Lawyers</a>
        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Customers</a>
        <a href="{{ route('admin.appointments') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Appointments</a>
        <a href="{{ route('admin.services') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Services</a>
        <a href="{{ route('admin.messages') }}" class="px-4 py-2 rounded-lg bg-primary-500 text-white text-sm font-medium">Messages</a>
        <a href="{{ route('admin.content') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-sm font-medium hover:bg-gray-50">Content</a>
    </div>

    <div class="space-y-4">
        @forelse($messages as $message)
        <div class="bg-white border border-gray-100 rounded-lg p-5">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="font-semibold text-gray-800">{{ $message->name }} <span class="text-gray-400 font-normal text-sm">({{ $message->email }})</span></p>
                    <p class="text-sm text-primary-500">{{ $message->subject }}</p>
                </div>
                <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline text-sm">Delete</button>
                </form>
            </div>
            <p class="text-gray-600 text-sm">{{ $message->message }}</p>
            <p class="text-gray-400 text-xs mt-2">{{ $message->submitted_at->format('d M Y, h:i A') }}</p>
        </div>
        @empty
        <div class="bg-white border border-gray-100 rounded-lg p-10 text-center text-gray-400">No messages yet.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $messages->links() }}</div>

</section>
@endsection