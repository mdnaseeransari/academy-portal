<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optimal Classes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-600">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo-optimal-classes.png') }}" alt="Optimal Classes" class="h-10">
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center gap-8">
            <a href="/#home" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">About Us</a>
            <a href="{{ route('courses') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Courses & Fee</a>
            <a href="{{ route('results') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Results</a>
            <a href="{{ route('gallery') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Gallery</a>
            <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Contact</a>
        </div>

        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#2c3e80] text-white px-4 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-medium text-sm">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 text-sm transition font-medium">Register</a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="mobile-menu-button" class="text-gray-700 hover:text-[#2c3e80] focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden bg-white border-b border-gray-100 px-6 py-4 hidden">
        <div class="flex flex-col gap-4">
            <a href="/#home" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">About Us</a>
            <a href="{{ route('courses') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Courses & Fee</a>
            <a href="{{ route('results') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Results</a>
            <a href="{{ route('gallery') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Gallery</a>
            <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Contact</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#2c3e80] text-white px-4 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-medium text-sm text-center">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 text-sm transition font-medium text-center">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    
    <!-- Footer -->
<footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center md:text-left">
            <div>
                <p class="text-sm mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Optimal Classes, New Colony Kakarmatta Varanasi, Uttar Pradesh
                </p>
                <p class="text-sm mb-2">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 7V5z"/>
                    </svg>
                    +91 9415228666 | +91 7380922230
                </p>
                <p class="text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    optimalclassesvns@gmail.com
                </p>
            </div>
            <div class="text-center">
                <p class="text-sm">Optimal Classes © 2026. All Rights Reserved.</p>
                <p class="text-sm text-gray-400">Designed with ❤️ for students of Varanasi</p>
            </div>
            <div class="text-right">
                <div class="flex justify-end gap-4">
                    <a href="#" class="text-sm hover:text-gray-300 transition">Facebook</a>
                    <a href="#" class="text-sm hover:text-gray-300 transition">Instagram</a>
                    <a href="#" class="text-sm hover:text-gray-300 transition">YouTube</a>
                </div>
            </div>
        </div>
    </div>
</footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
