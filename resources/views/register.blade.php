@extends('layouts.app')

@section('title', 'Register Account')

@section('content')

<section class="py-12 sm:py-16 px-4">
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200/80 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[600px]">

            <!-- Left Column: Legal Network Brand Card -->
            <div class="lg:col-span-4 relative hidden lg:block bg-primary-950 overflow-hidden">
                <img src="{{ asset('images/auth-legal.jpg') }}" alt="Justice and Equality" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-900/60 to-primary-950/80"></div>
                
                <div class="absolute inset-0 p-8 flex flex-col justify-between text-white z-10">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-accent text-xs font-semibold border border-white/15 mb-4">
                            <i class="bi bi-shield-check text-accent"></i>
                            <span>Bar Verified Platform</span>
                        </div>
                        <h2 class="text-2xl font-bold leading-tight text-white">Join Pakistan's Legal Network</h2>
                        <p class="text-xs text-slate-300 mt-2 leading-relaxed">Whether you are seeking legal counsel or a practicing advocate looking to manage clients, LawyerConnect provides the ultimate platform.</p>
                    </div>

                    <div class="border-t border-white/10 pt-4 space-y-3 text-xs text-slate-300">
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-person-check-fill text-accent text-sm"></i>
                            <span><strong>For Clients:</strong> Instant booking with verified advocates</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-briefcase-fill text-accent text-sm"></i>
                            <span><strong>For Advocates:</strong> Direct client booking &amp; scheduling</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Registration Form -->
            <div class="lg:col-span-8 p-8 sm:p-12 flex flex-col justify-center">
                <div class="mb-6">
                    <span class="text-accent text-xs font-semibold uppercase tracking-wider">Get Started</span>
                    <h1 class="text-2xl sm:text-3xl font-bold text-primary-900 mt-1">Create your account</h1>
                    <p class="text-sm text-gray-500 mt-1">Register in less than a minute to begin booking or managing consultations.</p>
                </div>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm flex items-start gap-2 shadow-sm">
                    <i class="bi bi-exclamation-circle-fill text-red-500 shrink-0 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    <!-- Account Type Switcher -->
                    <div class="mb-6 bg-gray-50 p-3 rounded-2xl border border-gray-200/80">
                        <label class="block text-gray-700 font-semibold text-xs uppercase tracking-wider mb-2">Select Account Type:</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-center gap-2 py-2.5 px-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-accent transition shadow-sm">
                                <input type="radio" name="role" value="customer" checked
                                       id="role-customer" class="role-radio accent-accent">
                                <span class="text-sm font-semibold text-gray-800">I am a Client</span>
                            </label>
                            <label class="flex items-center justify-center gap-2 py-2.5 px-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-accent transition shadow-sm">
                                <input type="radio" name="role" value="lawyer"
                                       id="role-lawyer" class="role-radio accent-accent">
                                <span class="text-sm font-semibold text-gray-800">I am an Advocate</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Full Legal Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="e.g. Advocate Tariq Ali" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Password</label>
                            <input type="password" name="password"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="Minimum 8 characters" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-1.5">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="Re-enter password" required>
                        </div>
                    </div>

                    <!-- Advocate Specific Fields -->
                    <div id="lawyer-fields" class="hidden border-t border-gray-200 pt-5 mt-5 space-y-4">
                        <div class="flex items-center gap-2 text-primary-900 font-bold text-sm">
                            <i class="bi bi-briefcase-fill text-accent"></i>
                            <span>Advocate Practice Credentials</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Contact Phone</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       placeholder="+92 300 1234567">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">City / Jurisdiction</label>
                                <input type="text" name="city" value="{{ old('city') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       placeholder="e.g. Lahore, Karachi, Islamabad">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Primary Specialization</label>
                                <select name="specialization" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm">
                                    <option value="">Select Specialization</option>
                                    @foreach($services as $service)
                                    <option value="{{ $service->name }}" {{ old('specialization') == $service->name ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Academic Qualification</label>
                                <input type="text" name="qualification" value="{{ old('qualification') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       placeholder="e.g. LLB, LLM">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Years of Experience</label>
                                <input type="number" name="experience_years" value="{{ old('experience_years') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       min="0" placeholder="e.g. 8">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Consultation Fee (Rs.)</label>
                                <input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       min="0" placeholder="e.g. 5000">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Bar Council Registration No.</label>
                                <input type="text" name="bar_council_number" value="{{ old('bar_council_number') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       placeholder="e.g. SC-12345">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium text-xs mb-1">Office / Chamber Address</label>
                                <input type="text" name="address" value="{{ old('address') }}"
                                       class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent text-sm"
                                       placeholder="Chambers number, court premises">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-accent hover:bg-amber-400 text-primary-950 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer mt-6">
                        <i class="bi bi-person-plus-fill text-base"></i>
                        <span>Complete Registration</span>
                    </button>

                </form>

                <p class="text-center text-gray-600 mt-6 text-xs">
                    Already registered?
                    <a href="{{ route('login') }}" class="text-primary-900 font-bold hover:text-accent transition ml-1">Sign in here</a>
                </p>

            </div>
        </div>
    </div>
</section>

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

@endsection
