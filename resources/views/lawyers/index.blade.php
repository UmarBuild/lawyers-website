@extends('layouts.app')

@section('title', 'Find Lawyers')

@section('content')

<section class="py-10 px-4 max-w-7xl mx-auto">

    <h1 class="text-3xl font-bold text-primary-900 mb-6">Find a Lawyer</h1>

    {{-- Filter Bar --}}
    <form action="{{ route('lawyers.index') }}" method="GET"
          class="bg-white border border-gray-100 rounded-lg shadow-sm p-5 mb-8 grid grid-cols-1 md:grid-cols-5 gap-3">

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
               class="px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500 md:col-span-2">

        <select name="city" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>

        <select name="specialization" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
            <option value="">All Specializations</option>
            @foreach($specializations as $specialization)
                <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                    {{ $specialization }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
            <option value="">Newest First</option>
            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
            <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
            <option value="fee_low" {{ request('sort') == 'fee_low' ? 'selected' : '' }}>Lowest Fee</option>
        </select>

        <div class="md:col-span-5 flex justify-end gap-3">
            @if(request()->anyFilled(['search', 'city', 'specialization', 'sort']))
                <a href="{{ route('lawyers.index') }}" class="text-sm text-gray-500 hover:text-gray-700 self-center">
                    Clear filters
                </a>
            @endif
            <button type="submit"
                    class="bg-primary-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-600 transition">
                Search
            </button>
        </div>
    </form>

    {{-- Results --}}
    <p class="text-gray-500 mb-4 text-sm">{{ $lawyers->total() }} lawyer(s) found</p>

    @if($lawyers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($lawyers as $lawyer)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-primary-500 text-white flex items-center justify-center text-xl font-bold shrink-0">
                            {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $lawyer->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $lawyer->specialization }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-gray-500 mb-2">
                        <span>📍 {{ $lawyer->city }}</span>
                        <span class="flex items-center gap-1 text-accent font-medium">
                            ⭐ {{ number_format($lawyer->rating, 1) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 mb-4">{{ $lawyer->experience_years }} years experience</p>

                    <div class="flex items-center justify-between">
                        <span class="text-primary-500 font-semibold">Rs. {{ number_format($lawyer->consultation_fee) }}</span>
                        <a href="{{ route('lawyers.show', $lawyer->id) }}"
                           class="text-sm bg-primary-500 text-white px-4 py-2 rounded hover:bg-primary-600 transition">
                            View Profile
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $lawyers->appends(request()->query())->links() }}
        </div>
    @else
        <div class="bg-white border border-gray-100 rounded-lg p-10 text-center text-gray-400">
            No lawyers found matching your filters.
        </div>
    @endif

</section>

@endsection