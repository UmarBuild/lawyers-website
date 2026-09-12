@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

<!-- Executive Page Header -->
<section class="bg-primary-900 text-white py-14 border-b border-primary-800">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <span class="text-accent text-xs font-semibold uppercase tracking-wider">Get in Touch</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white mt-2">Legal Support &amp; Inquiries</h1>
        <p class="text-sm sm:text-base text-slate-300 mt-3 max-w-2xl mx-auto">Have a question regarding advocate verification, appointment scheduling, or corporate partnerships? Reach out to our dedicated support team.</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

            <!-- Left Column: Contact Form -->
            <div class="lg:col-span-7 bg-white rounded-2xl shadow-sm border border-gray-200/80 p-6 sm:p-10">
                <h3 class="text-2xl font-bold text-primary-900 mb-2">Send Us a Direct Message</h3>
                <p class="text-sm text-gray-500 mb-8">Fill in your inquiry details below and an administrative officer will review your request.</p>

                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 text-sm flex items-start gap-2 shadow-sm">
                    <i class="bi bi-exclamation-circle-fill text-red-500 shrink-0 mt-0.5"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-2">Your Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="e.g. Muhammad Farhan" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-semibold text-sm mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                   placeholder="e.g. name@example.com" required>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                               placeholder="e.g. Appointment Reschedule / General Query" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold text-sm mb-2">Message</label>
                        <textarea name="message" rows="5"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:bg-white text-sm"
                                  placeholder="Provide relevant case or portal details..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-accent hover:bg-amber-400 text-primary-950 py-3.5 rounded-xl font-bold text-sm transition-all duration-200 shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <i class="bi bi-send-fill text-sm"></i>
                        <span>Transmit Inbound Inquiry</span>
                    </button>

                </form>
            </div>

            <!-- Right Column: Corporate Legal Office Card with Image -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/80 overflow-hidden">
                    <div class="relative h-48 overflow-hidden bg-primary-900 group">
                        <img src="{{ asset('images/contact-legal.jpg') }}" alt="LawyerConnect Official Headquarters" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-950 via-primary-950/40 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="bg-accent text-primary-950 text-[10px] font-extrabold px-2.5 py-0.5 rounded uppercase tracking-wider">Administrative Registry</span>
                            <h4 class="text-base font-bold mt-1 text-white">Central Operations Office</h4>
                        </div>
                    </div>

                    <div class="p-6 space-y-4 text-sm">
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100">
                            <div class="w-9 h-9 rounded-lg bg-primary-50 text-primary-900 flex items-center justify-center shrink-0 text-base">
                                <i class="bi bi-geo-alt-fill text-accent"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Registered Address</span>
                                <span class="text-gray-600 text-xs">{{ $footerAddress ?? 'Karachi, Pakistan' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 pb-3 border-b border-gray-100">
                            <div class="w-9 h-9 rounded-lg bg-primary-50 text-primary-900 flex items-center justify-center shrink-0 text-base">
                                <i class="bi bi-envelope-fill text-accent"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Official Communication</span>
                                <span class="text-gray-600 text-xs">{{ $footerEmail ?? 'info@lawyerconnect.com' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-lg bg-primary-50 text-primary-900 flex items-center justify-center shrink-0 text-base">
                                <i class="bi bi-telephone-fill text-accent"></i>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Helpline &amp; Support</span>
                                <span class="text-gray-600 text-xs">{{ $footerPhone ?? '+92 300 1234567' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support Assurance Card -->
                <div class="bg-primary-900 text-white rounded-2xl p-6 shadow-md border border-primary-800 space-y-3">
                    <div class="flex items-center gap-2 text-accent text-xs font-semibold uppercase tracking-wider">
                        <i class="bi bi-clock-history"></i>
                        <span>Guaranteed Response SLA</span>
                    </div>
                    <h4 class="font-bold text-white text-base">Rapid Case Coordination</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        All client and advocate inquiries submitted through this portal are logged and responded to by our legal administration desk within 24 business hours.
                    </p>
                </div>

            </div>

        </div>

    </div>
</section>

@endsection