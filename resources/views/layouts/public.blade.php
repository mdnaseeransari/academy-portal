<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optimal Classes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-600">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <span class="text-xl font-bold text-[#2c3e80]">Optimal Classes</span>
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
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 mt-12">
        <div class="container mx-auto px-6 text-center">
            <p class="text-sm text-gray-500">Optimal Classes &copy; 2025. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
