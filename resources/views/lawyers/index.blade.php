@extends('layouts.app')

@section('title', 'Find Lawyers')

@section('content')

<section class="py-10">
    <div class="max-w-7xl mx-auto px-4">

        <h2 class="text-2xl font-bold text-gray-800 mb-6">Find Lawyers</h2>

        <form method="GET" class="flex flex-wrap gap-2 mb-8">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name..."
                   class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-primary-500">

            <select name="city" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-primary-500">
                <option value="">All Cities</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>

            <select name="specialization" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-primary-500">
                <option value="">All Specializations</option>
                @foreach($specializations as $spec)
                <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>{{ $spec }}</option>
                @endforeach
            </select>

            <select name="sort" class="px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-primary-500">
                <option value="">Sort By</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rating</option>
                <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Most Experienced</option>
                <option value="fee_low" {{ request('sort') == 'fee_low' ? 'selected' : '' }}>Lowest Fee</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm hover:bg-primary-600">Filter</button>
            <a href="{{ route('lawyers.index') }}" class="px-4 py-2 border rounded-lg text-sm text-gray-600 hover:bg-gray-50">Clear</a>
        </form>

        @if($lawyers->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($lawyers as $lawyer)
            <div class="bg-white border rounded-xl p-6 hover:shadow-lg transition">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-primary-50 rounded-full flex items-center justify-center text-primary-500 text-xl font-bold flex-shrink-0">
                        {{ strtoupper(substr($lawyer->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $lawyer->name }}</h3>
                        <p class="text-primary-500 text-sm">{{ $lawyer->specialization }}</p>
                    </div>
                </div>

                <div class="space-y-1 text-sm text-gray-500">
                    <p><span class="font-medium text-gray-700">City:</span> {{ $lawyer->city }}</p>
                    <p><span class="font-medium text-gray-700">Experience:</span> {{ $lawyer->experience_years }} years</p>
                    <p><span class="font-medium text-gray-700">Fee:</span> Rs. {{ $lawyer->consultation_fee }}</p>
                </div>

                <div class="flex items-center gap-0.5 mt-3">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $lawyer->rating ? 'text-yellow-400' : 'text-gray-200' }}">&#9733;</span>
                    @endfor
                    <span class="text-xs text-gray-400 ml-1">{{ $lawyer->rating }}</span>
                </div>

                <a href="{{ route('lawyers.show', $lawyer->id) }}" class="block mt-4 text-center bg-primary-500 text-white py-2 rounded-lg hover:bg-primary-600 transition text-sm font-medium">View Profile</a>
            </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $lawyers->withQueryString()->links() }}
        </div>
        @else
        <div class="text-center py-16 text-gray-400">
            <p class="text-lg">No lawyers found.</p>
        </div>
        @endif

    </div>
</section>

@endsection