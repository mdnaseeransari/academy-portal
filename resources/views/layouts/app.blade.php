<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Optimal Classes') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-600" x-data="{ sidebarOpen: false }">
    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
        class="fixed left-0 top-0 h-screen w-64 bg-[#2c3e80] text-white z-50 transition-transform duration-300 ease-in-out shadow-xl overflow-y-auto">
        
        <!-- Logo Area -->
        <div class="h-16 flex items-center px-6 border-b border-white/10">
            <span class="text-xl font-bold tracking-tight">Optimal Classes</span>
        </div>

        <!-- Navigation Links -->
        <nav class="mt-6 space-y-1">
            @stack('sidebar-links')
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-4">
                <!-- Hamburger -->
                <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="text-lg font-semibold text-gray-800 lg:hidden">Dashboard</h2>
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end mr-2">
                    <span class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                    <span class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <!-- Profile Link -->
                    <a href="{{ route('profile.edit') }}" class="p-2 text-gray-400 hover:text-[#2c3e80] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-6 text-center">
            <p class="text-sm text-gray-500">Optimal Classes &copy; 2025. All rights reserved.</p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
