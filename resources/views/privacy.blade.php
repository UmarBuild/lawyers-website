@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')

<section class="py-10 sm:py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 prose prose-base sm:prose-lg">

        <h1 class="text-3xl sm:text-4xl font-bold text-primary-700 mb-6">Privacy Policy</h1>
        <p class="text-gray-500 mb-8">Last updated: {{ date('F j, Y') }}</p>

        <p class="text-gray-700 leading-relaxed mb-6">
            LawyerConnect ("we", "us", "our") respects your privacy. This Privacy Policy explains
            what personal information we collect, how we use it, and the choices you have. By using
            this website, you agree to the practices described below.
        </p>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">1. Information We Collect</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li><strong>Account information:</strong> name, email address, phone number, city, and address — collected when you register.</li>
            <li><strong>Lawyer-specific information:</strong> qualification, experience, consultation fee, bar council number, and available days — collected only from lawyers.</li>
            <li><strong>Appointment data:</strong> selected lawyer, date, time, and any message you attach to a booking.</li>
            <li><strong>Contact messages:</strong> name, email, subject, and message — collected when you use the contact form.</li>
            <li><strong>Technical data:</strong> IP address and browser user-agent, collected automatically for security and fraud prevention.</li>
        </ul>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">2. How We Use Information</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>To create and manage your account.</li>
            <li>To process and track your appointments.</li>
            <li>To send notifications about your appointments (e.g., approval, rejection, cancellation).</li>
            <li>To respond to your queries submitted via the contact form.</li>
            <li>To allow the admin team to review and approve lawyer registrations.</li>
        </ul>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">3. Information Sharing</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            We do not sell your personal information. Your contact details and appointment data are
            visible only to you, the lawyer you booked with, and authorized administrators of
            LawyerConnect. We may disclose information when required by law.
        </p>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">4. Data Security</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            Passwords are stored using one-way bcrypt hashing. Sessions are managed through
            Laravel's encrypted session driver. We use role-based access control to ensure that
            customers, lawyers, and admins can only access the data they are entitled to.
        </p>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">5. Your Rights</h2>
        <ul class="list-disc list-inside space-y-2 text-gray-700">
            <li>You may update your profile information at any time from your dashboard.</li>
            <li>You may cancel pending or approved appointments.</li>
            <li>You may request deletion of your account by contacting the admin.</li>
        </ul>

        <h2 class="text-xl sm:text-2xl font-bold text-primary-700 mt-8 mb-3">6. Contact</h2>
        <p class="text-gray-700 leading-relaxed mb-6">
            If you have any questions about this Privacy Policy, please use the
            <a href="{{ route('contact') }}" class="text-primary-500 hover:underline">contact form</a>.
        </p>

    </div>
</section>

@endsection