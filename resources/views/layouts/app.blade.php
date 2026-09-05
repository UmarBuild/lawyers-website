<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LawyerConnect') | LawyerConnect</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>

<body class="font-poppins bg-gray-50 min-h-screen flex flex-col">

    <nav class="bg-primary-500 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide flex items-center gap-2">

                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 6h-2V4c0-1.1-.9-2-2-2H7c-1.1 0-2 .9-2 2v2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM7 4h10v2H7V4z"/>
                </svg>
                LawyerConnect
            </a>

            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div id="nav-links" class="hidden md:flex items-center gap-1">

                <a href="{{ route('home') }}" class="px-3 py-2 rounded hover:bg-primary-600 transition">Home</a>

                <a href="{{ route('lawyers.index') }}" class="px-3 py-2 rounded hover:bg-primary-600 transition">Lawyers</a>

                <a href="{{ route('contact') }}" class="px-3 py-2 rounded hover:bg-primary-600 transition">Contact</a>

                @guest
                <a href="{{ route('login') }}" class="px-3 py-2 rounded hover:bg-primary-600 transition">Login</a>
                <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-accent text-primary-900 font-semibold rounded hover:bg-yellow-400 transition">Register</a>
                @endguest

                @auth

                <div class="relative" id="user-dropdown">
                    <button id="dropdown-btn" class="px-3 py-2 rounded hover:bg-primary-600 transition flex items-center gap-1">

                        {{ auth()->user()->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg shadow-lg py-2 z-50">

                        @if(auth()->user()->isLawyer())
                        <a href="{{ route('lawyer.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">My Dashboard</a>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Admin Panel</a>
                        @endif

                        @if(auth()->user()->isCustomer())
                        <a href="{{ route('my-appointments') }}" class="block px-4 py-2 hover:bg-gray-100">My Appointments</a>
                        @endif

                        <hr class="my-1 border-gray-200">

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 hover:bg-gray-100 text-red-500">Logout</a>
                    </div>
                </div>

                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
    <div class="bg-green-500 text-white px-6 py-3 text-center">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-500 text-white px-6 py-3 text-center">
        {{ session('error') }}
    </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-primary-900 text-gray-300 mt-auto">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div>
                    <h3 class="text-white font-bold text-lg mb-3">LawyerConnect</h3>
                    <p class="text-sm">Find the best lawyers in your city. Book appointments online easily and quickly.</p>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('lawyers.index') }}" class="hover:text-white transition">Find Lawyers</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold text-lg mb-3">Contact Info</h3>
                    <p class="text-sm">info@lawyerconnect.com</p>
                    <p class="text-sm">+92 300 1234567</p>
                    <p class="text-sm">Karachi, Pakistan</p>
                </div>

            </div>
            <div class="border-t border-primary-700 mt-6 pt-4 text-center text-sm">
                &copy; {{ date('Y') }} LawyerConnect. All rights reserved.
            </div>
        </div>
    </footer>

    @auth
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
    @endauth

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>