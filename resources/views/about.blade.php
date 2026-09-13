@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<!-- Executive Page Header -->
<section class="bg-primary-900 text-white py-10 sm:py-14 border-b border-primary-800">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">About LawyerConnect</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Empowering Citizens with Verified Legal Counsel</h1>
        <p class="text-sm sm:text-base text-slate-300 mt-3 max-w-2xl mx-auto">Connecting clients across Pakistan with trusted, bar-registered legal advocates seamlessly and transparently.</p>
    </div>
</section>

<!-- Mission & Story with Realistic Law Library Image -->
<section class="py-10 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 sm:gap-12 items-center mb-12 sm:mb-16">
            
            <div class="lg:col-span-6 space-y-5 text-gray-700 leading-relaxed">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-50 text-primary-900 text-xs font-semibold border border-primary-100">
                    <i class="bi bi-shield-check text-accent"></i>
                    <span>Our Founding Mission</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-primary-900 tracking-tight">Making Quality Legal Protection Accessible To Everyone</h2>
                <p>
                    Access to experienced legal help should never depend on personal connections or uncertain referrals. Whether navigating complex corporate law, commercial litigation, family disputes, real estate transactions, or urgent criminal defense, LawyerConnect bridges the gap between top legal minds and those who need their counsel.
                </p>
                <p>
                    Every advocate on our platform is thoroughly verified through their respective provincial Bar Councils. We provide transparent ratings, verifiable track records, clear consultation fees, and real-time scheduling so you can make informed legal decisions with confidence.
                </p>
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="border-l-2 border-accent pl-4">
                        <div class="text-2xl font-bold text-primary-900">100%</div>
                        <div class="text-xs text-gray-500 font-medium">Bar Verified Advocates</div>
                    </div>
                    <div class="border-l-2 border-accent pl-4">
                        <div class="text-2xl font-bold text-primary-900">24/7</div>
                        <div class="text-xs text-gray-500 font-medium">Appointment Booking Flow</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-100 group">
                    <img src="{{ asset('images/about-legal.jpg') }}" alt="Law Library and Legal Research" class="w-full h-[260px] sm:h-[400px] object-cover transition duration-700 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary-950/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5 bg-white/95 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/40 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-accent/20 text-accent flex items-center justify-center text-lg">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 font-semibold">Strict Standard of Excellence</div>
                                <div class="text-sm font-bold text-primary-900">Vetted Legal Professionals Only</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Three Core Pillars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16">

            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-8 hover:shadow-lg transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-xl mb-5 shadow-sm">
                    <i class="bi bi-patch-check"></i>
                </div>
                <h3 class="font-bold text-lg text-primary-900 mb-2">Verified Advocates</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Every advocate profile is vetted against Bar Council credentials and administrative compliance before public listing.
                </p>
            </div>

            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-8 hover:shadow-lg transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-xl mb-5 shadow-sm">
                    <i class="bi bi-calendar2-check"></i>
                </div>
                <h3 class="font-bold text-lg text-primary-900 mb-2">Streamlined Booking</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Select your preferred consultation date and time slot, submit your case overview, and receive direct advocate confirmation.
                </p>
            </div>

            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-8 hover:shadow-lg transition duration-200">
                <div class="w-12 h-12 rounded-xl bg-primary-900 text-accent flex items-center justify-center text-xl mb-5 shadow-sm">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h3 class="font-bold text-lg text-primary-900 mb-2">Private &amp; Confidential</h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Your contact details and case briefing notes remain strictly between you and your booked legal advisor under advocate-client privilege.
                </p>
            </div>

        </div>

        <!-- How It Works Section -->
        <div class="bg-primary-900 text-white rounded-3xl p-8 sm:p-12 shadow-xl border border-primary-800">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-accent text-xs font-semibold uppercase tracking-wider">Simple 4-Step Process</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mt-1">How LawyerConnect Works</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                <div class="p-4">
                    <div class="w-12 h-12 rounded-full bg-accent text-primary-950 font-bold text-lg flex items-center justify-center mx-auto mb-3 shadow-md">1</div>
                    <h4 class="font-bold text-white text-sm mb-1">Browse Advocates</h4>
                    <p class="text-xs text-slate-300">Filter by specialization, city, fee, and real client ratings.</p>
                </div>

                <div class="p-4">
                    <div class="w-12 h-12 rounded-full bg-accent text-primary-950 font-bold text-lg flex items-center justify-center mx-auto mb-3 shadow-md">2</div>
                    <h4 class="font-bold text-white text-sm mb-1">Pick an Open Slot</h4>
                    <p class="text-xs text-slate-300">Choose an available day and consultation time matching the advocate's schedule.</p>
                </div>

                <div class="p-4">
                    <div class="w-12 h-12 rounded-full bg-accent text-primary-950 font-bold text-lg flex items-center justify-center mx-auto mb-3 shadow-md">3</div>
                    <h4 class="font-bold text-white text-sm mb-1">Get Confirmation</h4>
                    <p class="text-xs text-slate-300">Receive instant in-app notifications once the advocate approves the request.</p>
                </div>

                <div class="p-4">
                    <div class="w-12 h-12 rounded-full bg-accent text-primary-950 font-bold text-lg flex items-center justify-center mx-auto mb-3 shadow-md">4</div>
                    <h4 class="font-bold text-white text-sm mb-1">Consult &amp; Rate</h4>
                    <p class="text-xs text-slate-300">Attend your consultation session and leave a verified review to help fellow citizens.</p>
                </div>
            </div>

            <div class="mt-10 text-center pt-8 border-t border-primary-800">
                <a href="{{ route('lawyers.index') }}" class="inline-flex items-center gap-2 bg-accent hover:bg-amber-400 text-primary-950 font-bold px-8 py-3.5 rounded-xl transition shadow-lg text-sm">
                    <i class="bi bi-search"></i>
                    <span>Find Your Advocate Today</span>
                </a>
            </div>
        </div>

    </div>
</section>

@endsection
