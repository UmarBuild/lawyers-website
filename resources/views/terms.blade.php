@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 prose prose-lg">

        <h1 class="text-4xl font-bold text-primary-700 mb-6">Terms &amp; Conditions</h1>
        <p class="text-gray-500 mb-8">Last updated: {{ date('F j, Y') }}</p>

        <p class="text-gray-700 leading-relaxed mb-6">
            These Terms &amp; Conditions govern your use of the LawyerConnect website. By registering
            an account or using any part of the platform, you accept these terms in full. If you
            disagree with any part, do not use our website.
        </p>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">1. Account Registration</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>You must provide accurate and complete information when registering.</li>
            <li>You are responsible for keeping your password confidential.</li>
            <li>Lawyers must hold a valid bar council number to register as a lawyer.</li>
            <li>Lawyer accounts require admin approval before they can log in.</li>
        </ul>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">2. Appointments</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>Booking an appointment is a request, not a guarantee — the lawyer must approve it.</li>
            <li>You may cancel a pending or approved appointment at any time.</li>
            <li>Lawyers may approve, reject, or mark appointments as completed.</li>
            <li>Consultation fees are agreed between you and the lawyer; LawyerConnect does not handle payments.</li>
        </ul>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">3. Ratings</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            After a completed appointment, customers may rate the lawyer from 1 to 5 stars. Ratings
            are aggregated into the lawyer's public rating. Abusive or fraudulent ratings may be
            removed by the admin team.
        </p>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">4. Acceptable Use</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>You may not use the platform for any unlawful purpose.</li>
            <li>You may not harass, threaten, or impersonate other users.</li>
            <li>You may not attempt to access data that does not belong to you.</li>
        </ul>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">5. Liability</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            LawyerConnect is a listing and booking platform. We are not a law firm and do not
            provide legal advice. We are not liable for the outcome of any consultation between a
            customer and a lawyer booked through our platform.
        </p>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">6. Changes to These Terms</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            We may revise these Terms &amp; Conditions from time to time. The latest version will
            always be available on this page, with the updated "Last updated" date.
        </p>

        <h2 class="text-2xl font-bold text-primary-700 mt-8 mb-3">7. Contact</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            Questions about these terms? Use our
            <a href="{{ route('contact') }}" class="text-primary-500 hover:underline">contact form</a>.
        </p>

    </div>
</section>

@endsection
