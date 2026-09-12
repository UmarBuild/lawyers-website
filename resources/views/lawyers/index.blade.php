@extends('layouts.app')

@section('title', 'Find Advocates')

@section('content')

<!-- Executive Find Advocates Header -->
<section class="bg-primary-900 text-white py-12 border-b border-primary-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <span class="text-accent text-xs font-semibold uppercase tracking-wider">Advocate Directory</span>
                <h1 class="text-3xl font-extrabold text-white mt-1">Verified Legal Advocates</h1>
                <p class="text-sm text-slate-300 mt-1">Browse and book appointments with verified lawyers across all jurisdictions in Pakistan.</p>
            </div>
            <div class="hidden lg:flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/15 shadow-sm">
                <i class="bi bi-shield-check text-accent text-2xl"></i>
                <div class="text-xs">
                    <span class="font-bold text-white block">100% Bar Registered</span>
                    <span class="text-slate-300">Credentials verified &amp; approved</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-10 px-4 sm:px-6 max-w-7xl mx-auto">

    {{-- Filter Bar --}}
    <form action="{{ route('lawyers.index') }}" method="GET"
          class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6 mb-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-center">

        <div class="relative md:col-span-2">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <i class="bi bi-search text-xs"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search advocate by name..."
                   class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm">
        </div>

        <div>
            <select name="city" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="specialization" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm">
                <option value="">All Specializations</option>
                @foreach($specializations as $specialization)
                    <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                        {{ $specialization }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <select name="sort" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm">
                <option value="">Newest First</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                <option value="fee_low" {{ request('sort') == 'fee_low' ? 'selected' : '' }}>Lowest Fee</option>
            </select>
        </div>

        <div class="sm:col-span-2 md:col-span-5 flex justify-end items-center gap-3 pt-2 border-t border-gray-100">
            @if(request()->anyFilled(['search', 'city', 'specialization', 'sort']))
                <a href="{{ route('lawyers.index') }}" class="text-xs text-gray-500 hover:text-primary-900 font-medium self-center">
                    Clear all filters
                </a>
            @endif
            <button type="submit"
                    class="bg-accent hover:bg-amber-400 text-primary-950 px-6 py-2.5 rounded-xl font-bold text-sm transition shadow-sm flex items-center gap-1.5 cursor-pointer">
                <i class="bi bi-funnel text-xs"></i>
                <span>Apply Filters</span>
            </button>
        </div>
    </form>

    {{-- Results Counter --}}
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600 text-sm font-medium">
            Showing <span class="font-bold text-primary-900">{{ $lawyers->total() }}</span> registered advocate(s)
        </p>
    </div>

    @if($lawyers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($lawyers as $lawyer)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 hover:shadow-xl transition duration-300 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-primary-50 border border-primary-100 text-primary-900 flex items-center justify-center text-xl font-bold shrink-0 shadow-inner">
                                {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-gray-900 text-base truncate">{{ $lawyer->name }}</h3>
                                <p class="text-xs text-primary-700 font-semibold truncate">{{ $lawyer->specialization }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                    <i class="bi bi-geo-alt"></i> {{ $lawyer->city }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs py-2.5 border-t border-b border-gray-100 mb-3">
                            <span class="text-gray-500">{{ $lawyer->experience_years }} yrs experience</span>
                            <span class="flex items-center gap-1 text-accent font-bold">
                                ★ {{ number_format($lawyer->rating, 1) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-2 pt-2">
                        <div>
                            <span class="text-[11px] text-gray-600 block">Consultation Fee</span>
                            <span class="text-primary-900 font-extrabold text-sm">Rs. {{ number_format($lawyer->consultation_fee) }}</span>
                        </div>
                        <a href="{{ route('lawyers.show', $lawyer->id) }}"
                           class="text-xs bg-primary-900 hover:bg-primary-800 text-white font-semibold px-4 py-2.5 rounded-xl transition shadow-sm flex items-center gap-1">
                            <span>View Profile</span>
                            <i class="bi bi-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $lawyers->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white border border-gray-200/80 rounded-2xl p-12 text-center">
            <div class="w-14 h-14 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3 text-2xl">
                <i class="bi bi-search"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-base mb-1">No Advocates Found</h3>
            <p class="text-sm text-gray-500">No registered advocates matched your search filters. Try adjusting specialization or city.</p>
        </div>
    @endif

</section>

@endsection