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
                    {{-- Only show Dashboard if user is fully approved --}}
                    @if (auth()->user()->status === 'approved')
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Dashboard</a>
                    @else
                        {{-- If pending or rejected, show logout instead of dashboard --}}
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-[#2c3e80] text-sm font-medium">Logout</button>
                        </form>
                    @endif
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
                    {{-- Only show Dashboard if user is fully approved --}}
                    @if (auth()->user()->status === 'approved')
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-[#2c3e80] transition">Dashboard</a>
                    @else
                        {{-- If pending or rejected, show logout instead of dashboard --}}
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-[#2c3e80] text-sm font-medium">Logout</button>
                        </form>
                    @endif
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

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/919415228666" target="_blank" class="fixed bottom-8 right-8 z-[100] group flex items-center" aria-label="Chat on WhatsApp">
        <!-- Tooltip -->
        <span class="mr-4 bg-white text-gray-800 px-4 py-2 rounded-xl shadow-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0 pointer-events-none border border-gray-100">
            Need help? Chat with us
        </span>
        
        <div class="relative flex items-center justify-center">
            <!-- Pulsing Animation -->
            <div class="absolute inset-0 bg-[#25D366] rounded-full animate-ping opacity-20"></div>
            
            <!-- Button Container -->
            <div class="relative bg-[#25D366] text-white p-4 rounded-2xl shadow-[0_10px_40px_rgba(37,211,102,0.4)] hover:bg-[#20ba5a] transition-all duration-300 transform group-hover:scale-110 group-hover:-translate-y-1">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
        </div>
    </a>
</body>
</html>
