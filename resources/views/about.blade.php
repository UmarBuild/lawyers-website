@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4">

        <h1 class="text-4xl font-bold text-primary-700 mb-4">About LawyerConnect</h1>
        <p class="text-lg text-gray-600 mb-10">
            LawyerConnect is an online platform that connects customers with verified lawyers
            across Pakistan. We make it easy to search by specialization, city, and rating,
            and to book appointments online — without long waits or phone tag.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

            <div class="bg-primary-50 rounded-lg p-6">
                <div class="text-3xl mb-3">⚖️</div>
                <h3 class="font-bold text-lg mb-2">Verified Lawyers</h3>
                <p class="text-sm text-gray-600">
                    Every lawyer on our platform is reviewed and approved by our admin team
                    before being listed publicly.
                </p>
            </div>

            <div class="bg-primary-50 rounded-lg p-6">
                <div class="text-3xl mb-3">📅</div>
                <h3 class="font-bold text-lg mb-2">Easy Booking</h3>
                <p class="text-sm text-gray-600">
                    Pick a time slot, send a request, and get a confirmation — all in one
                    streamlined online flow.
                </p>
            </div>

            <div class="bg-primary-50 rounded-lg p-6">
                <div class="text-3xl mb-3">🔒</div>
                <h3 class="font-bold text-lg mb-2">Private &amp; Secure</h3>
                <p class="text-sm text-gray-600">
                    Your contact details and appointment history are visible only to you and
                    the lawyer you booked with — never to the public.
                </p>
            </div>

        </div>

        <h2 class="text-2xl font-bold text-primary-700 mb-4">Our Mission</h2>
        <p class="text-gray-600 mb-4 leading-relaxed">
            Access to legal help should not depend on who you know. Whether you need a criminal
            defense lawyer, help with a divorce, an affidavit drafted, or corporate counsel for
            your business, LawyerConnect gives you a single place to compare qualified lawyers,
            view their experience and fees, and book the right one for your case.
        </p>

        <h2 class="text-2xl font-bold text-primary-700 mt-10 mb-4">How It Works</h2>
        <ol class="list-decimal list-inside space-y-2 text-gray-600">
            <li>Register as a customer — it takes less than a minute.</li>
            <li>Search lawyers by specialization, city, or rating.</li>
            <li>View the lawyer's profile, fee, and availability.</li>
            <li>Book an appointment at a time that suits you.</li>
            <li>Receive a confirmation once the lawyer approves the request.</li>
            <li>After your appointment, rate the lawyer to help other users.</li>
        </ol>

        <div class="mt-12 p-6 bg-primary-500 text-white rounded-lg text-center">
            <h3 class="text-xl font-bold mb-2">Ready to find the right lawyer?</h3>
            <a href="{{ route('lawyers.index') }}"
               class="inline-block mt-2 bg-white text-primary-700 px-6 py-2 rounded-lg font-semibold hover:bg-primary-50 transition">
                Browse Lawyers
            </a>
        </div>

    </div>
</section>

@endsection
