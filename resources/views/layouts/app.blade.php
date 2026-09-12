<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LawyerConnect') | LawyerConnect</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body class="font-poppins bg-slate-50 min-h-screen flex flex-col antialiased text-gray-800">

    <!-- Unified Executive Navbar -->
    <nav class="bg-primary-900 text-white shadow-xl border-b border-primary-800/80 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold tracking-wide flex items-center gap-2.5 text-white hover:text-accent transition">
                <span class="w-9 h-9 rounded-lg bg-accent/20 border border-accent/40 flex items-center justify-center text-accent text-lg shadow-sm">
                    <i class="bi bi-bank2"></i>
                </span>
                <span>Lawyer<span class="text-accent">Connect</span></span>
            </a>

            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none p-2 rounded-lg hover:bg-white/10 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div id="nav-links" class="hidden md:flex items-center gap-1">

                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Home</a>

                <a href="{{ route('lawyers.index') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Lawyers</a>

                <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">About</a>

                <a href="{{ route('contact') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Contact</a>

                @auth
                    {{-- Role-based Dashboard link visible in the top nav bar --}}
                    @if(auth()->user()->isCustomer())
                        <a href="{{ route('customer.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                        <a href="{{ route('my-appointments') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Appointments</a>
                    @elseif(auth()->user()->isLawyer())
                        <a href="{{ route('lawyer.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                        <a href="{{ route('lawyer.appointments') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Appointments</a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Admin Panel</a>
                    @endif
                @endauth

                @guest
                <a href="{{ route('login') }}" class="px-3.5 py-2 rounded-lg text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition">Login</a>
                <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-accent hover:bg-amber-400 text-primary-950 text-sm font-bold rounded-lg shadow-sm transition">Register</a>
                @endguest

                @auth

                @php
                    $navNotifications = auth()->user()->notifications()->latest()->take(10)->get();
                    $navUnreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                @endphp

                <!-- Notification Bell Dropdown (Harmonized with Navbar) -->
                <div class="relative mr-1.5" id="notification-dropdown">
                    <button id="notif-btn" type="button" class="relative p-2 rounded-lg text-slate-200 hover:text-white hover:bg-white/10 transition flex items-center justify-center focus:outline-none" title="Notifications" aria-label="Notifications">
                        <i class="bi bi-bell text-lg"></i>
                        <span id="nav-notif-badge" class="{{ $navUnreadCount > 0 ? '' : 'hidden' }} absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full min-w-[18px] text-center border-2 border-primary-900 shadow-md animate-pulse">
                            {{ $navUnreadCount > 99 ? '99+' : $navUnreadCount }}
                        </span>
                    </button>

                    <!-- Notifications Panel -->
                    <div id="notif-menu" class="hidden absolute right-0 mt-2.5 w-80 sm:w-96 bg-white text-gray-800 rounded-2xl shadow-2xl border border-gray-200/80 py-0 z-50 overflow-hidden">
                        <div class="px-4 py-3.5 bg-primary-900 text-white flex items-center justify-between border-b border-primary-800">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-bell-fill text-accent text-sm"></i>
                                <span class="font-bold text-sm">Notifications</span>
                                @if($navUnreadCount > 0)
                                <span id="notif-count-tag" class="bg-accent/20 text-accent text-[11px] font-semibold px-2 py-0.5 rounded-full border border-accent/40">
                                    {{ $navUnreadCount }} new
                                </span>
                                @endif
                            </div>
                            @if($navNotifications->count() > 0)
                            <button id="mark-all-read-btn" type="button" class="text-xs text-accent hover:text-amber-300 font-medium transition cursor-pointer">
                                Mark all read
                            </button>
                            @endif
                        </div>

                        <div class="max-h-80 overflow-y-auto divide-y divide-gray-100" id="notif-list">
                            @forelse($navNotifications as $notif)
                            <div class="p-3.5 hover:bg-slate-50 transition flex items-start gap-3 notif-item {{ !$notif->is_read ? 'bg-primary-50/60' : '' }}" data-id="{{ $notif->id }}">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-xs {{ !$notif->is_read ? 'bg-primary-900 text-accent shadow-sm' : 'bg-gray-100 text-gray-500' }}">
                                    <i class="bi {{ $notif->iconClass() }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    @if($notif->link)
                                    <a href="{{ $notif->link }}" class="text-xs font-semibold text-gray-800 hover:text-primary-900 line-clamp-2 leading-relaxed block">
                                        {{ $notif->message }}
                                    </a>
                                    @else
                                    <p class="text-xs text-gray-700 leading-relaxed font-medium">
                                        {{ $notif->message }}
                                    </p>
                                    @endif
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[11px] text-gray-600 flex items-center gap-1">
                                            <i class="bi bi-clock"></i> {{ $notif->timeAgo() }}
                                        </span>
                                        @if(!$notif->is_read)
                                        <span class="w-2 h-2 rounded-full bg-accent inline-block notif-unread-dot" title="Unread"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="py-8 px-4 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-2">
                                    <i class="bi bi-bell-slash text-xl"></i>
                                </div>
                                <p class="text-xs text-gray-500 font-medium">No notifications yet</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">We'll alert you when appointments or updates arrive.</p>
                            </div>
                            @endforelse
                        </div>

                        @if($navNotifications->count() > 0)
                        <div class="p-2.5 bg-gray-50 text-center border-t border-gray-100">
                            <span class="text-[11px] text-gray-500">Notifications mark as read when opened</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- User Dropdown (Harmonized) -->
                <div class="relative" id="user-dropdown">
                    <button id="dropdown-btn" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition flex items-center gap-2 text-sm font-medium text-white focus:outline-none">
                        <div class="w-7 h-7 rounded-full bg-accent/20 border border-accent/40 text-accent flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2.5 w-52 bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-100 py-2 z-50">

                        @if(auth()->user()->isLawyer())
                        <a href="{{ route('lawyer.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">My Dashboard</a>
                        <a href="{{ route('lawyer.edit-profile') }}" class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a>
                        <a href="{{ route('lawyer.appointments') }}" class="block px-4 py-2 hover:bg-gray-100">My Appointments</a>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Admin Panel</a>
                        <a href="{{ route('admin.content') }}" class="block px-4 py-2 hover:bg-gray-100">Manage Content</a>
                        @endif

                        @if(auth()->user()->isCustomer())
                        <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">My Dashboard</a>
                        <a href="{{ route('customer.profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a>
                        <a href="{{ route('customer.password.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Change Password</a>
                        <a href="{{ route('my-appointments') }}" class="block px-4 py-2 hover:bg-gray-100">My Appointments</a>
                        @endif

                        <hr class="my-1 border-gray-200">

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:bg-gray-100 text-red-500">Logout</a>
                    </div>
                </div>

                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="bg-green-500 text-white px-6 py-3 text-center">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500 text-white px-6 py-3 text-center">
        {{ session('error') }}
    </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-primary-950 text-slate-400 border-t border-primary-900 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <div class="md:col-span-1">
                    <a href="{{ route('home') }}" class="text-xl font-bold tracking-wide flex items-center gap-2 text-white mb-3">
                        <i class="bi bi-bank2 text-accent"></i>
                        <span>Lawyer<span class="text-accent">Connect</span></span>
                    </a>
                    <p class="text-sm text-slate-400 leading-relaxed">{{ $footerAbout }}</p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-accent">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>100% Encrypted &amp; Confidential</span>
                    </div>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-b border-primary-900 pb-2">Quick Links</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Home</a></li>
                        <li><a href="{{ route('lawyers.index') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Find Advocates</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-b border-primary-900 pb-2">Legal &amp; Policy</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('privacy') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-accent transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-xs text-accent"></i> Report an Issue</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-4 border-b border-primary-900 pb-2">Official Contact</h3>
                    <div class="space-y-2.5 text-sm">
                        <p class="flex items-center gap-2"><i class="bi bi-envelope text-accent"></i> <span>{{ $footerEmail }}</span></p>
                        <p class="flex items-center gap-2"><i class="bi bi-telephone text-accent"></i> <span>{{ $footerPhone }}</span></p>
                        <p class="flex items-center gap-2"><i class="bi bi-geo-alt text-accent"></i> <span>{{ $footerAddress }}</span></p>
                    </div>
                </div>

            </div>
            <div class="border-t border-primary-900 mt-10 pt-6 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} LawyerConnect. All rights reserved. Registered Bar Advocates Network.
            </div>
        </div>
    </footer>

    @auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    @endauth

    <script src="{{ asset('js/app.js') }}"></script>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifBtn = document.getElementById('notif-btn');
            const notifMenu = document.getElementById('notif-menu');
            const notifBadge = document.getElementById('nav-notif-badge');
            const notifCountTag = document.getElementById('notif-count-tag');
            const markAllBtn = document.getElementById('mark-all-read-btn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            let isMarked = false;

            function markNotificationsAsRead() {
                if (isMarked) return;
                
                if (notifBadge && !notifBadge.classList.contains('hidden')) {
                    notifBadge.classList.add('hidden');
                }
                if (notifCountTag) {
                    notifCountTag.style.display = 'none';
                }
                document.querySelectorAll('.notif-unread-dot').forEach(dot => dot.remove());
                document.querySelectorAll('.notif-item').forEach(item => item.classList.remove('bg-blue-50/40'));

                if (csrfToken) {
                    fetch('{{ route("notifications.read", "all") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(res => {
                        if (res.ok) isMarked = true;
                    }).catch(err => console.error('Failed to sync notification status:', err));
                }
            }

            if (notifBtn && notifMenu) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const willOpen = notifMenu.classList.contains('hidden');
                    
                    // Close user dropdown if open
                    const userMenu = document.getElementById('dropdown-menu');
                    if (userMenu) userMenu.classList.add('hidden');

                    if (willOpen) {
                        notifMenu.classList.remove('hidden');
                        // When dropdown opens, mark notifications as read
                        markNotificationsAsRead();
                    } else {
                        notifMenu.classList.add('hidden');
                    }
                });

                if (markAllBtn) {
                    markAllBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        markNotificationsAsRead();
                    });
                }

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                        notifMenu.classList.add('hidden');
                    }
                });
            }

            // Close notif menu if user dropdown opens
            const userBtn = document.getElementById('dropdown-btn');
            if (userBtn && notifMenu) {
                userBtn.addEventListener('click', function() {
                    notifMenu.classList.add('hidden');
                });
            }
        });
    </script>
    @endauth

    @stack('scripts')

</body>
</html>