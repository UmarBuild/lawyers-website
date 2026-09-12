@extends('layouts.app')

@section('title', 'Home')

@section('content')

<!-- Realistic Legal Hero Section -->
<section class="relative bg-gradient-to-br from-primary-950 via-primary-900 to-primary-800 text-white overflow-hidden py-14 lg:py-20 border-b border-primary-800/80">
    <!-- Subtle Ambient Background Accents -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#c5a059_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-primary-700/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Column: Legal Content & Search -->
            <div class="lg:col-span-7 text-left">
                <!-- Trust Pill -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-accent text-xs font-semibold uppercase tracking-wider mb-5">
                    <i class="bi bi-shield-check text-accent text-sm"></i>
                    <span>Pakistan's Verified Legal Network</span>
                </div>

                <!-- Hero Heading -->
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    {{ $heroTitle }}
                </h1>

                <!-- Hero Subtitle -->
                <p class="text-base sm:text-lg text-slate-300 mb-8 leading-relaxed max-w-xl font-normal">
                    {{ $heroSubtitle }}
                </p>

                <!-- Floating Search & Filter Bar -->
                <div class="bg-white/10 backdrop-blur-md p-2.5 sm:p-3 rounded-2xl border border-white/20 shadow-2xl max-w-2xl">
                    <form action="{{ route('lawyers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i class="bi bi-search text-sm"></i>
                            </span>
                            <input type="text" name="search" placeholder="Search advocate by name..."
                                   class="w-full pl-10 pr-4 py-3 bg-white text-gray-900 placeholder-gray-400 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent border-0 shadow-inner">
                        </div>

                        <div class="relative sm:w-52">
                            <select name="specialization" class="w-full px-3.5 py-3 bg-white text-gray-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-accent border-0 shadow-inner appearance-none cursor-pointer">
                                <option value="">All Specializations</option>
                                @foreach($services as $service)
                                <option value="{{ $service->name }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <i class="bi bi-chevron-down text-xs"></i>
                            </span>
                        </div>

                        <button type="submit" class="px-6 py-3 bg-accent hover:bg-amber-400 text-primary-950 font-bold text-sm rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shrink-0 cursor-pointer">
                            <span>Search</span>
                            <i class="bi bi-arrow-right text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Trust Highlights -->
                <div class="flex flex-wrap items-center gap-5 sm:gap-8 mt-8 pt-6 border-t border-white/10 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-patch-check-fill text-accent text-base"></i>
                        <span>Admin Verified Advocates</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-lock-fill text-accent text-base"></i>
                        <span>100% Confidential</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar2-check-fill text-accent text-base"></i>
                        <span>Instant Online Booking</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Realistic Legal Imagery Card -->
            <div class="lg:col-span-5 relative mt-6 lg:mt-0">
                <!-- Outer Decorative Glow -->
                <div class="absolute -inset-1 bg-gradient-to-r from-accent/30 to-primary-600/30 rounded-3xl blur-xl opacity-75 group-hover:opacity-100 transition duration-1000"></div>

                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-2 border-white/15 bg-primary-900 group">
                    <!-- Realistic Legal Consultation Image from local public/images/ -->
                    <img src="{{ asset('images/hero-lawyer.jpg') }}"
                         alt="Professional Legal Consultation"
                         class="w-full h-[360px] sm:h-[420px] object-cover object-top transition duration-700 ease-out group-hover:scale-105">

                    <!-- Gradient Shadow Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/30 to-transparent"></div>

                    <!-- Floating Top Status Tag -->
                    <div class="absolute top-4 right-4 bg-primary-950/85 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/20 text-xs text-white font-medium flex items-center gap-2 shadow-lg">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Verified Advocates Online</span>
                    </div>

                    <!-- Floating Bottom Legal Card -->
                    <div class="absolute bottom-4 left-4 right-4 bg-primary-900/90 backdrop-blur-md p-4 rounded-xl border border-white/15 text-white shadow-xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-accent/20 border border-accent/40 flex items-center justify-center text-accent text-lg shrink-0">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <div>
                                    <h4 class="text-xs text-slate-300 font-medium">Premier Legal Counsel</h4>
                                    <p class="text-sm font-bold text-white">Expert Advocates Across Pakistan</p>
                                </div>
                            </div>
                            <div class="bg-white/10 px-2.5 py-1 rounded-md text-xs font-semibold text-accent flex items-center gap-1 shrink-0">
                                <span>★ 4.9 / 5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Floating Key Metrics Bar -->
<section class="relative z-20 max-w-7xl mx-auto px-4 -mt-8 sm:-mt-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 flex items-center gap-5 hover:shadow-2xl transition duration-300">
            <div class="w-14 h-14 rounded-xl bg-primary-50 text-primary-500 flex items-center justify-center text-2xl shrink-0 border border-primary-100">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-primary-900">{{ $totalLawyers }}</div>
                <div class="text-sm text-gray-500 font-medium">Verified Advocates</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 flex items-center gap-5 hover:shadow-2xl transition duration-300">
            <div class="w-14 h-14 rounded-xl bg-primary-50 text-primary-500 flex items-center justify-center text-2xl shrink-0 border border-primary-100">
                <i class="bi bi-journal-text"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-primary-900">{{ $services->count() }}</div>
                <div class="text-sm text-gray-500 font-medium">Practice Areas &amp; Specializations</div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 flex items-center gap-5 hover:shadow-2xl transition duration-300">
            <div class="w-14 h-14 rounded-xl bg-primary-50 text-primary-500 flex items-center justify-center text-2xl shrink-0 border border-primary-100">
                <i class="bi bi-clock-history"></i>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-primary-900">{{ $statOnlineValue }}</div>
                <div class="text-sm text-gray-500 font-medium">{{ $statOnlineLabel }}</div>
            </div>
        </div>

    </div>
</section>

@if($featuredLawyers->count() > 0)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <span class="text-accent font-semibold text-xs uppercase tracking-wider">Top Rated Advocates</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-1">Featured Legal Experts</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($featuredLawyers as $lawyer)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition duration-300 flex flex-col justify-between">

                <div>
                    <div class="w-20 h-20 bg-primary-50 border-2 border-primary-100 rounded-full flex items-center justify-center text-primary-500 text-2xl font-bold mx-auto mb-4 shadow-sm">
                        {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ $lawyer->name }}</h3>
                    <p class="text-primary-500 text-center text-sm font-medium mt-0.5">{{ $lawyer->specialization }}</p>
                    <p class="text-gray-500 text-center text-sm mt-0.5 flex items-center justify-center gap-1">
                        <i class="bi bi-geo-alt"></i> {{ $lawyer->city }}
                    </p>

                    <!-- Rating Stars -->
                    <div class="flex items-center justify-center gap-1 mt-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $lawyer->rating)
                                <span class="text-accent text-base">&#9733;</span>
                            @else
                                <span class="text-gray-300 text-base">&#9733;</span>
                            @endif
                        @endfor
                        <span class="text-sm font-semibold text-gray-700 ml-1.5">{{ number_format($lawyer->rating, 1) }}</span>
                    </div>

                    <div class="flex justify-between mt-5 pt-4 border-t border-gray-100 text-sm text-gray-600">
                        <span class="font-semibold text-primary-900">Rs. {{ number_format($lawyer->consultation_fee) }}</span>
                        <span>{{ $lawyer->experience_years }} yrs experience</span>
                    </div>
                </div>

                <a href="{{ route('lawyers.show', $lawyer->id) }}" class="block mt-5 text-center bg-primary-500 text-white font-medium py-2.5 rounded-xl hover:bg-primary-600 transition shadow-sm">
                    View Profile
                </a>

            </div>
            @endforeach

        </div>
    </div>
</section>
@endif

<section class="py-16 bg-slate-100/70 border-t border-gray-200/60">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <span class="text-accent font-semibold text-xs uppercase tracking-wider">Practice Areas</span>
            <h2 class="text-3xl font-bold text-gray-900 mt-1">Browse by Legal Specialization</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            @foreach($services as $service)
            <a href="{{ route('lawyers.index') }}?specialization={{ urlencode($service->name) }}"
               class="bg-white rounded-xl p-5 text-center hover:shadow-lg hover:border-accent/40 border border-gray-200/70 transition duration-200 group">
                <div class="text-2xl text-primary-500 mb-2 group-hover:text-accent transition">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="text-gray-800 font-semibold text-sm group-hover:text-primary-500 transition">{{ $service->name }}</div>
            </a>
            @endforeach

        </div>
    </div>
</section>

@endsection