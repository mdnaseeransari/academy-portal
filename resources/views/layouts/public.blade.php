<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Page Title --}}
    <title>@yield('title', 'Best Coaching Institute near Kakarmatta & DLW Varanasi | Optimal Classes')</title>

    {{-- Meta Description --}}
    <meta name="description" content="@yield('meta_description', 'Optimal Classes — Top coaching institute near Kakarmatta and DLW Colony, Varanasi. Expert coaching for Class 6-12, IIT-JEE and NEET. New Colony Kakarmatta, Varanasi. Call +91 9415228666')">

    {{-- Meta Keywords --}}
    <meta name="keywords" content="@yield('meta_keywords', 'coaching near kakarmatta, coaching near DLW varanasi, best coaching institute varanasi, IIT JEE coaching varanasi, NEET coaching varanasi, optimal classes varanasi, class 6 to 12 coaching varanasi')">

    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Robots --}}
    <meta name="robots" content="index, follow">

    {{-- Open Graph (WhatsApp / Facebook preview) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Optimal Classes">
    <meta property="og:title" content="@yield('title', 'Best Coaching near Kakarmatta & DLW Varanasi | Optimal Classes')">
    <meta property="og:description" content="@yield('meta_description', 'Top coaching institute near Kakarmatta and DLW Colony Varanasi. Class 6-12, IIT-JEE and NEET coaching.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/logo-optimal-classes.webp') }}">

    {{-- Schema Markup --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "EducationalOrganization",
        "name": "Optimal Classes",
        "description": "Top coaching institute near Kakarmatta and DLW Colony Varanasi. Class 6-12, IIT-JEE and NEET coaching.",
        "url": "https://www.optimalclasses.in",
        "logo": "https://www.optimalclasses.in/images/logo-optimal-classes.webp",
        "telephone": ["+919415228666", "+917380922230"],
        "email": "optimalclassesvns@gmail.com",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "New Colony, Kakarmatta",
            "addressLocality": "Varanasi",
            "addressRegion": "Uttar Pradesh",
            "addressCountry": "IN"
        },
        "areaServed": [
            "Kakarmatta", "DLW Colony", "BLW", "Sunderpur",
            "Susuwahi", "Lahartara", "Lanka", "Bhelupur",
            "Durgakund", "Shivpur", "Varanasi"
        ],
        "founder": {
            "@@type": "Person",
            "name": "Shobhit Kumar Srivastava",
            "jobTitle": "Director"
        },
        "sameAs": [
            "https://www.facebook.com/people/Optimal-Classes/61551640119156",
            "https://www.instagram.com/optimal_classes",
            "https://www.youtube.com/@Optimal_Classes"
        ]
    }
    </script>

    {{-- Preload critical images --}}
    <link rel="preload" href="{{ asset('images/logo-optimal-classes.webp') }}" as="image">

    @yield('head')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

   
    <style>
        html { scroll-behavior: smooth; }

        @media (max-width: 768px) {
          .notif-static-text { display: none; }
          .notif-marquee-wrapper {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            flex: 1;
          }
          .notif-marquee-text {
            display: inline-block;
            animation: marquee-slide 12s linear infinite;
            white-space: nowrap;
            color: white;
            font-size: 13px;
          }
          @keyframes marquee-slide {
            0%   { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
          }

          /* WhatsApp mobile size adjustments */
          .whatsapp-float {
            bottom: 15px !important;
            right: 15px !important;
          }
          .whatsapp-icon-container {
            padding: 10px !important;
            border-radius: 12px !important;
          }
          .whatsapp-svg {
            width: 25px !important;
            height: 25px !important;
          }

          /* Footer padding bottom to show social links above WhatsApp button */
          footer {
            padding-bottom: 70px !important;
          }
        }

        @media (min-width: 769px) {
          .notif-marquee-wrapper { display: none; }
          .notif-static-text { display: inline; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-600">
    @if(isset($activeNotification))
        <div id="top-notification-bar" class="w-full gap-3 px-4 text-white select-none" style="background: linear-gradient(90deg, #0a1628, #1a3a8f, #0a1628); min-height: 44px; height: auto; padding-top: 8px; padding-bottom: 8px; display: flex; align-items: center; justify-content: center; flex-wrap: wrap; text-align: center; position: fixed; top: 0; left: 0; width: 100%; z-index: 9999;">
            <!-- Bell Icon -->
            <svg class="w-4 h-4 text-white flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
            </svg>

            <!-- Notice Badge -->
            <span class="text-[11px] font-black uppercase tracking-wider rounded-full text-white whitespace-nowrap select-none" style="background-color: #00c896; padding: 2px 10px; line-height: 1;">
                Notice
            </span>

            <!-- Message Text -->
            <span class="text-white font-medium max-w-[75vw] notif-static-text" style="font-size: 13.5px; margin-left: 8px;">
                {{ $activeNotification->message }}
            </span>

            <div class="notif-marquee-wrapper">
                <span class="notif-marquee-text">
                    {{ $activeNotification->message }}
                </span>
            </div>
        </div>
    @endif
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 h-16 flex items-center justify-between px-6 sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-2">
            <a href="{{ url('/') }}" class="inline-flex items-center">
                <img src="{{ asset('images/logo-optimal-classes.webp') }}" alt="Optimal Classes" class="h-10" loading="eager" fetchpriority="high">
            </a>
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
    <div id="mobile-menu" class="md:hidden fixed left-0 right-0 z-40 bg-white border-b border-gray-100 px-6 py-4 hidden overflow-y-auto">
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
            </div>
            <div class="text-right">
                <div class="flex justify-end gap-4">
                    <a href="https://www.facebook.com/people/Optimal-Classes/61551640119156/?mibextid=wwXIfr&rdid=xltLHPzFAMo6iKTS&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F19kS34o7fS%2F%3Fmibextid%3DwwXIfr" target="_blank" rel="noreferrer" class="text-sm hover:text-gray-300 transition">Facebook</a>
                    <a href="https://www.instagram.com/optimal_classes?igsh=M3Iwc280YW1oaHVh&utm_source=qr" target="_blank" rel="noreferrer" class="text-sm hover:text-gray-300 transition">Instagram</a>
                    <a href="https://www.youtube.com/@Optimal_Classes" target="_blank" rel="noreferrer" class="text-sm hover:text-gray-300 transition">YouTube</a>
                </div>
            </div>
        </div>
    </div>
</footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', function() {
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (mobileMenu) {
                        mobileMenu.classList.toggle('hidden');
                    }
                });
            }

            // Dynamic Spacing Adjustment
            function adjustSpacing() {
                const notifBar = document.getElementById('top-notification-bar');
                const navbar = document.querySelector('nav');
                const mobileMenu = document.getElementById('mobile-menu');
                const main = document.querySelector('main');

                // Clear any inline styles from previous main element padding logic
                if (main) {
                    main.style.paddingTop = '0px';
                }

                const barHeight = (notifBar && notifBar.offsetHeight > 0) ? notifBar.offsetHeight : 0;
                const navHeight = navbar ? navbar.offsetHeight : 64;
                const totalHeight = barHeight + navHeight;

                document.body.style.paddingTop = totalHeight + 'px';

                if (navbar) {
                    navbar.style.position = 'fixed';
                    navbar.style.left = '0';
                    navbar.style.right = '0';
                    navbar.style.top = barHeight + 'px';
                    navbar.style.marginTop = '0px';
                }

                if (mobileMenu) {
                    mobileMenu.style.top = totalHeight + 'px';
                    mobileMenu.style.maxHeight = 'calc(100vh - ' + totalHeight + 'px)';
                }
            }

            adjustSpacing();
            window.addEventListener('resize', adjustSpacing);
        });
    </script>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/919415228666" target="_blank" class="fixed bottom-8 right-8 z-[100] group flex items-center whatsapp-float" aria-label="Chat on WhatsApp">
        <!-- Tooltip -->
        <span class="mr-4 bg-white text-gray-800 px-4 py-2 rounded-xl shadow-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0 pointer-events-none border border-gray-100">
            Need help? Chat with us
        </span>
        
        <div class="relative flex items-center justify-center">
            <!-- Pulsing Animation -->
            <div class="absolute inset-0 bg-[#25D366] rounded-full animate-ping opacity-20"></div>
            
            <!-- Button Container -->
            <div class="relative bg-[#25D366] text-white p-4 rounded-2xl shadow-[0_10px_40px_rgba(37,211,102,0.4)] hover:bg-[#20ba5a] transition-all duration-300 transform group-hover:scale-110 group-hover:-translate-y-1 whatsapp-icon-container">
                <svg class="w-8 h-8 whatsapp-svg" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
        </div>
    </a>
</body>
</html>
