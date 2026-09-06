@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<section class="py-10 px-4 max-w-2xl mx-auto">

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
        @endif

        <form action="{{ route('lawyer.update-profile') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $lawyer->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $lawyer->phone) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">City</label>
                    <input type="text" name="city" value="{{ old('city', $lawyer->city) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Specialization</label>
                    <select name="specialization" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                        @foreach($services as $service)
                        <option value="{{ $service }}" {{ old('specialization', $lawyer->specialization) == $service ? 'selected' : '' }}>{{ $service }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification', $lawyer->qualification) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Experience (Years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $lawyer->experience_years) }}" min="0" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Consultation Fee (Rs.)</label>
                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $lawyer->consultation_fee) }}" min="0" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Address</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">{{ old('address', $lawyer->address) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Available Days</label>
                <div class="flex flex-wrap gap-3">
                    @php $currentDays = old('available_days', $lawyer->getAvailableDays()); @endphp
                    @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="available_days[]" value="{{ $day }}" class="accent-primary-500" {{ in_array($day, $currentDays) ? 'checked' : '' }}>
                        {{ ucfirst($day) }}
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Available From</label>
                    <input type="time" name="available_time_start" value="{{ old('available_time_start', $lawyer->available_time_start) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Available Till</label>
                    <input type="time" name="available_time_end" value="{{ old('available_time_end', $lawyer->available_time_end) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                </div>
            </div>

            <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition">Save Changes</button>
        </form>
    </div>

</section>
@endsection