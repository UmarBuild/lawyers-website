@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<!-- Executive Page Header -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">Activity Center</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Your Notifications</h1>
        <p class="text-sm sm:text-base text-slate-300 mt-3 max-w-2xl mx-auto">
            View, manage, and clear all your appointment and account notifications in one place.
        </p>
    </div>
</section>

<section class="py-10 sm:py-12 bg-slate-50 min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-4">

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Action bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-primary-700 transition self-start">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            @if($notifications->count() > 0)
            <form action="{{ route('notifications.delete', 'all') }}" method="POST"
                  onsubmit="return confirm('Delete ALL notifications? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 text-sm bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition shadow-sm">
                    <i class="bi bi-trash3"></i> Delete All
                </button>
            </form>
            @endif
        </div>

        {{-- Notifications list --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            @forelse($notifications as $notif)
            <div class="p-4 sm:p-5 flex items-start gap-3 sm:gap-4 border-b border-gray-100 last:border-b-0 {{ !$notif->is_read ? 'bg-primary-50/40' : '' }}">

                {{-- Icon --}}
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full flex items-center justify-center shrink-0 text-base {{ !$notif->is_read ? 'bg-primary-900 text-accent shadow-sm' : 'bg-gray-100 text-gray-500' }}">
                    <i class="bi {{ $notif->iconClass() }}"></i>
                </div>

                {{-- Message + time --}}
                <div class="flex-1 min-w-0">
                    @if($notif->link)
                    <a href="{{ $notif->link }}" class="text-sm sm:text-base font-semibold text-gray-800 hover:text-primary-900 leading-relaxed block">
                        {{ $notif->message }}
                    </a>
                    @else
                    <p class="text-sm sm:text-base text-gray-800 leading-relaxed font-medium">
                        {{ $notif->message }}
                    </p>
                    @endif
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <i class="bi bi-clock"></i> {{ $notif->timeAgo() }}
                        </span>
                        @if(!$notif->is_read)
                        <span class="w-2 h-2 rounded-full bg-accent inline-block" title="Unread"></span>
                        @endif
                    </div>
                </div>

                {{-- Delete button (simple form, no AJAX) --}}
                <form action="{{ route('notifications.delete', $notif->id) }}" method="POST"
                      onsubmit="return confirm('Delete this notification?');"
                      class="shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition"
                            title="Delete this notification" aria-label="Delete notification">
                        <i class="bi bi-trash3 text-sm sm:text-base"></i>
                    </button>
                </form>
            </div>
            @empty
            {{-- Empty state --}}
            <div class="py-16 px-4 text-center">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                    <i class="bi bi-bell-slash text-3xl"></i>
                </div>
                <p class="text-gray-700 font-semibold text-base sm:text-lg mb-1">No notifications yet</p>
                <p class="text-sm text-gray-500 max-w-md mx-auto">
                    We'll alert you here when appointments or updates arrive. Until then, feel free to browse advocates.
                </p>
                <a href="{{ route('lawyers.index') }}"
                   class="inline-flex items-center gap-2 mt-6 bg-primary-500 hover:bg-primary-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition">
                    <i class="bi bi-search"></i> Find Advocates
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @endif

    </div>
</section>

@endsection
