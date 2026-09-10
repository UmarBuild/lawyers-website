@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="bg-primary-500 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-4">{{ $heroTitle }}</h1>
        <p class="text-xl mb-8 text-primary-100">{{ $heroSubtitle }}</p>

        <form action="{{ route('lawyers.index') }}" method="GET" class="max-w-2xl mx-auto flex gap-2">
            <input type="text" name="search" placeholder="Search by name..."
                   class="flex-1 px-4 py-3 rounded-lg bg-white/20 text-white placeholder-white/70 border border-white/40 focus:outline-none focus:ring-2 focus:ring-white">

            <select name="specialization" class="px-4 py-3 rounded-lg bg-white text-black focus:outline-none">
                <option value="">All Specializations</option>
                @foreach($services as $service)
                <option value="{{ $service->name }}">{{ $service->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-6 py-3 bg-accent text-primary-900 font-bold rounded-lg hover:bg-yellow-400 transition">
                Search
            </button>
        </form>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

        <div class="p-6">
            <div class="text-4xl font-bold text-primary-500">{{ $totalLawyers }}</div>
            <div class="text-gray-600 mt-2">Verified Lawyers</div>
        </div>
        <div class="p-6">
            <div class="text-4xl font-bold text-primary-500">{{ $services->count() }}</div>
            <div class="text-gray-600 mt-2">Practice Areas</div>
        </div>
        <div class="p-6">
            <div class="text-4xl font-bold text-primary-500">{{ $statOnlineValue }}</div>
            <div class="text-gray-600 mt-2">{{ $statOnlineLabel }}</div>
        </div>

    </div>
</section>

@if($featuredLawyers->count() > 0)
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Top Rated Lawyers</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($featuredLawyers as $lawyer)
            <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition">

                <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center text-primary-500 text-2xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                </div>

                <h3 class="text-xl font-semibold text-center">{{ $lawyer->name }}</h3>
                <p class="text-primary-500 text-center text-sm">{{ $lawyer->specialization }}</p>
                <p class="text-gray-500 text-center text-sm">{{ $lawyer->city }}</p>

                <!-- Rating Stars -->
                <div class="flex items-center justify-center gap-1 mt-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $lawyer->rating)
                            <span class="text-yellow-400">&#9733;</span>
                        @else
                            <span class="text-gray-300">&#9733;</span>
                        @endif
                    @endfor
                    <span class="text-sm text-gray-500 ml-1">{{ $lawyer->rating }}</span>
                </div>

                <div class="flex justify-between mt-4 text-sm text-gray-600">
                    <span>Rs. {{ $lawyer->consultation_fee }}</span>
                    <span>{{ $lawyer->experience_years }} yrs exp</span>
                </div>

                <a href="{{ route('lawyers.show', $lawyer->id) }}" class="block mt-4 text-center bg-primary-500 text-white py-2 rounded-lg hover:bg-primary-600 transition">
                    View Profile
                </a>

            </div>
            @endforeach

        </div>
    </div>
</section>
@endif

<section class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">Specialization</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            @foreach($services as $service)
            <a href="{{ route('lawyers.index') }}?specialization={{ urlencode($service->name) }}"
               class="bg-white rounded-lg p-4 text-center hover:shadow-md transition">
                <div class="text-primary-500 font-semibold">{{ $service->name }}</div>
            </a>
            @endforeach

        </div>
    </div>
</section>

@endsection