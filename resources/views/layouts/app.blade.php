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

            <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold tracking-wide flex items-center gap-2.5 text-white hover:text-accent transition relative z-50">
                <span class="w-9 h-9 rounded-lg bg-accent/20 border border-accent/40 flex items-center justify-center text-accent text-lg shadow-sm">
                    <i class="bi bi-bank2"></i>
                </span>
                <span>Lawyer<span class="text-accent">Connect</span></span>
            </a>

            {{-- Right-side controls: notification bell (mobile + desktop) + hamburger + desktop nav --}}
            <div class="flex items-center gap-1">

                @auth
                    @php
                        $navNotifications = auth()->user()->notifications()->latest()->take(5)->get();
                        $navUnreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                    @endphp

                    {{-- Mobile bell — direct link to /notifications page (NO dropdown on mobile) --}}
                    <a href="{{ route('notifications.index') }}"
                       class="xl:hidden relative z-50 inline-flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10 focus:outline-none transition"
                       title="View all notifications" aria-label="Notifications">
                        <i class="bi bi-bell text-lg"></i>
                        <span class="{{ $navUnreadCount > 0 ? '' : 'hidden' }} absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full min-w-[18px] text-center border-2 border-primary-900 shadow-md animate-pulse">
                            {{ $navUnreadCount > 99 ? '99+' : $navUnreadCount }}
                        </span>
                    </a>

                    {{-- Desktop bell + dropdown (xl+ only) --}}
                    <div class="hidden xl:block relative mr-1.5" id="notification-dropdown">
                        <button id="notif-btn" type="button"
                                class="relative p-2 rounded-lg text-slate-200 hover:text-white hover:bg-white/10 transition flex items-center justify-center focus:outline-none"
                                title="Notifications" aria-label="Notifications">
                            <i class="bi bi-bell text-lg"></i>
                            <span id="nav-notif-badge" class="{{ $navUnreadCount > 0 ? '' : 'hidden' }} absolute -top-0.5 -right-0.5 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.2 rounded-full min-w-[18px] text-center border-2 border-primary-900 shadow-md animate-pulse">
                                {{ $navUnreadCount > 99 ? '99+' : $navUnreadCount }}
                            </span>
                        </button>

                        {{-- Dropdown panel --}}
                        <div id="notif-menu" class="hidden absolute right-0 mt-2.5 w-80 max-w-sm bg-white text-gray-800 rounded-2xl shadow-2xl border border-gray-200/80 py-0 z-50 overflow-hidden">
                            <div class="px-4 py-3.5 bg-primary-900 text-white flex items-center justify-between border-b border-primary-800">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-bell-fill text-accent text-sm"></i>
                                    <span class="font-bold text-sm">Notifications</span>
                                    @if($navUnreadCount > 0)
                                    <span class="bg-accent/20 text-accent text-[11px] font-semibold px-2 py-0.5 rounded-full border border-accent/40">
                                        {{ $navUnreadCount }} new
                                    </span>
                                    @endif
                                </div>
                                <a href="{{ route('notifications.index') }}" class="text-xs text-accent hover:text-amber-300 font-medium transition">
                                    See all
                                </a>
                            </div>

                            <div class="max-h-80 overflow-y-auto divide-y divide-gray-100">
                                @forelse($navNotifications as $notif)
                                <div class="p-3.5 hover:bg-slate-50 transition flex items-start gap-3 {{ !$notif->is_read ? 'bg-primary-50/60' : '' }}">
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
                                        <span class="text-[11px] text-gray-600 flex items-center gap-1 mt-1">
                                            <i class="bi bi-clock"></i> {{ $notif->timeAgo() }}
                                        </span>
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

                            {{-- See More button -> opens the full notifications page --}}
                            <a href="{{ route('notifications.index') }}"
                               class="block text-center py-3 bg-gray-50 text-primary-700 hover:bg-gray-100 text-xs font-bold border-t border-gray-100 transition">
                                <i class="bi bi-arrow-right-circle mr-1"></i> See More
                            </a>
                        </div>
                    </div>
                @endauth

                {{-- Hamburger button — visible below xl (1280px) --}}
                <button id="mobile-menu-btn" type="button"
                        class="xl:hidden relative z-50 inline-flex items-center justify-center w-10 h-10 rounded-lg text-white hover:bg-white/10 focus:outline-none transition"
                        aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Desktop nav — visible from xl (1280px) --}}
                <div id="nav-links" class="hidden xl:flex items-center gap-1">

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

                <!-- User Dropdown (Harmonized) -->
                <div class="relative" id="user-dropdown">
                    <button id="dropdown-btn" class="px-3 py-1.5 rounded-lg hover:bg-white/10 transition flex items-center gap-2 text-sm font-medium text-white focus:outline-none">
                        <div class="w-7 h-7 rounded-full bg-accent/20 border border-accent/40 text-accent flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:inline truncate max-w-[140px]">{{ auth()->user()->name }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2.5 w-52 bg-white text-gray-800 rounded-xl shadow-2xl border border-gray-100 py-2 z-50">

                        @if(auth()->user()->isLawyer())
                        <a href="{{ route('lawyer.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">My Dashboard</a>
                        <a href="{{ route('lawyer.edit-profile') }}" class="block px-4 py-2 hover:bg-gray-100">Edit Profile</a>
                        <a href="{{ route('lawyer.password.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Change Password</a>
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
            {{-- Close right-side controls wrapper (notification bell + hamburger + nav-links) --}}
            </div>
        </div>

        {{-- Mobile menu overlay — slides in from bottom --}}
        <div id="mobile-menu"
             class="xl:hidden fixed inset-0 z-40 pointer-events-none"
             aria-hidden="true">

            {{-- Backdrop --}}
            <div id="mobile-backdrop"
                 class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300 ease-out"
                 data-mobile-close></div>

            {{-- Panel slides from bottom --}}
            <div id="mobile-menu-panel"
                 class="absolute bottom-0 left-1/2 w-full max-w-md bg-primary-900 rounded-t-3xl shadow-2xl px-6 pt-6 pb-10 transition-transform duration-300 ease-out border-t-4 border-accent overflow-y-auto max-h-[90vh]"
                 style="transform: translate(-50%, 100%);">

                {{-- Handle bar --}}
                <div class="flex justify-center mb-4">
                    <span class="block w-12 h-1.5 bg-white/30 rounded-full"></span>
                </div>

                <div id="mobile-menu-links" class="flex flex-col items-center gap-3 text-center">

                    <a href="{{ route('home') }}"
                       class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                       data-mobile-close>
                        <i class="bi bi-house-door mr-2 text-accent"></i>Home
                    </a>

                    <a href="{{ route('lawyers.index') }}"
                       class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                       data-mobile-close>
                        <i class="bi bi-people mr-2 text-accent"></i>Lawyers
                    </a>

                    <a href="{{ route('about') }}"
                       class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                       data-mobile-close>
                        <i class="bi bi-info-circle mr-2 text-accent"></i>About
                    </a>

                    <a href="{{ route('contact') }}"
                       class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                       data-mobile-close>
                        <i class="bi bi-envelope mr-2 text-accent"></i>Contact
                    </a>

                    @auth
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('customer.dashboard') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-speedometer2 mr-2 text-accent"></i>Dashboard
                            </a>
                            <a href="{{ route('my-appointments') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-calendar-check mr-2 text-accent"></i>Appointments
                            </a>
                            <a href="{{ route('customer.profile.edit') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-person-gear mr-2 text-accent"></i>Edit Profile
                            </a>
                            <a href="{{ route('customer.password.edit') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-key mr-2 text-accent"></i>Change Password
                            </a>
                        @elseif(auth()->user()->isLawyer())
                            <a href="{{ route('lawyer.dashboard') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-speedometer2 mr-2 text-accent"></i>Dashboard
                            </a>
                            <a href="{{ route('lawyer.appointments') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-calendar-check mr-2 text-accent"></i>Appointments
                            </a>
                            <a href="{{ route('lawyer.edit-profile') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-person-gear mr-2 text-accent"></i>Edit Profile
                            </a>
                            <a href="{{ route('lawyer.password.edit') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-key mr-2 text-accent"></i>Change Password
                            </a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-shield-lock mr-2 text-accent"></i>Admin Panel
                            </a>
                            <a href="{{ route('admin.content') }}"
                               class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                               data-mobile-close>
                                <i class="bi bi-pencil-square mr-2 text-accent"></i>Manage Content
                            </a>
                        @endif

                        <span class="mobile-link block w-full max-w-xs h-px bg-white/15 my-1"></span>

                        <div class="mobile-link w-full max-w-xs flex items-center gap-3 px-5 py-3 rounded-xl bg-white/5">
                            <div class="w-9 h-9 rounded-full bg-accent/20 border border-accent/40 text-accent flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</span>
                        </div>

                        <a href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-semibold bg-red-500/90 hover:bg-red-500 transition"
                           data-mobile-close>
                            <i class="bi bi-box-arrow-right mr-2"></i>Logout
                        </a>
                    @endauth

                    @guest
                        <span class="mobile-link block w-full max-w-xs h-px bg-white/15 my-1"></span>

                        <a href="{{ route('login') }}"
                           class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-medium text-slate-200 hover:text-white hover:bg-white/10 transition bg-white/5"
                           data-mobile-close>
                            <i class="bi bi-box-arrow-in-right mr-2 text-accent"></i>Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="mobile-link w-full max-w-xs px-5 py-3 rounded-xl text-base font-semibold bg-accent hover:bg-amber-400 text-primary-950 transition"
                           data-mobile-close>
                            <i class="bi bi-person-plus mr-2"></i>Register
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Executive-styled flash messages — harmonized with navbar --}}
    @if(session('success'))
    <div class="bg-primary-900 text-white px-4 sm:px-6 py-3.5 text-sm sm:text-base text-center flex items-center justify-center gap-2.5 border-b-2 border-green-500/70 shadow-sm">
        <i class="bi bi-check-circle-fill text-green-400 text-base sm:text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-primary-900 text-white px-4 sm:px-6 py-3.5 text-sm sm:text-base text-center flex items-center justify-center gap-2.5 border-b-2 border-red-500/70 shadow-sm">
        <i class="bi bi-exclamation-triangle-fill text-red-400 text-base sm:text-lg"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if(session('info'))
    <div class="bg-primary-900 text-white px-4 sm:px-6 py-3.5 text-sm sm:text-base text-center flex items-center justify-center gap-2.5 border-b-2 border-accent/70 shadow-sm">
        <i class="bi bi-info-circle-fill text-accent text-base sm:text-lg"></i>
        <span>{{ session('info') }}</span>
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
            // ============================================================
            //  SIMPLE desktop notification dropdown toggle (xl+ only)
            //  Mobile bell is a direct link to /notifications — no JS
            // ============================================================
            const notifBtn  = document.getElementById('notif-btn');
            const notifMenu = document.getElementById('notif-menu');

            if (notifBtn && notifMenu) {
                notifBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Close user dropdown if open
                    const userMenu = document.getElementById('dropdown-menu');
                    if (userMenu) userMenu.classList.add('hidden');
                    notifMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                        notifMenu.classList.add('hidden');
                    }
                });
            }

            // Close notif dropdown if user dropdown opens
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