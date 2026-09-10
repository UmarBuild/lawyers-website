@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-xl shadow-lg p-8">

            <h2 class="text-3xl font-bold text-center text-primary-500 mb-6">Register</h2>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">I am a:</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="customer" checked
                                   id="role-customer" class="role-radio accent-primary-500">
                            <span>Customer</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="lawyer"
                                   id="role-lawyer" class="role-radio accent-primary-500">
                            <span>Lawyer</span>
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Password</label>
                        <input type="password" name="password"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" required>
                    </div>
                </div>

                <div id="lawyer-fields" class="hidden border-t pt-4 mt-4 space-y-4">

                    <h3 class="text-lg font-semibold text-gray-700">Lawyer Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Specialization</label>
                            <select name="specialization" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                                <option value="">Select</option>
                                @foreach($services as $service)
                                <option value="{{ $service->name }}" {{ old('specialization') == $service->name ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Qualification</label>
                            <input type="text" name="qualification" value="{{ old('qualification') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Experience (Years)</label>
                            <input type="number" name="experience_years" value="{{ old('experience_years') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" min="0">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Consultation Fee (Rs.)</label>
                            <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}"
                                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500" min="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Bar Council Number</label>
                        <input type="text" name="bar_council_number" value="{{ old('bar_council_number') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Address</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-primary-500">{{ old('address') }}</textarea>
                    </div>

                </div>

                <button type="submit" class="w-full bg-primary-500 text-white py-3 rounded-lg font-semibold hover:bg-primary-600 transition mt-6">
                    Register
                </button>

            </form>

            <p class="text-center text-gray-600 mt-4 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary-500 font-semibold hover:underline">Login</a>
            </p>

        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.role-radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
        var lawyerFields = document.getElementById('lawyer-fields');

        if (this.value === 'lawyer') {
            lawyerFields.classList.remove('hidden');
        } else {
            lawyerFields.classList.add('hidden');
        }
    });
});
</script>
@endpush
