@extends('layouts.public')

@section('content')
<div class="relative z-0 overflow-hidden min-h-screen flex flex-col items-center justify-center text-center px-6">
    <!-- Automatic Background Slideshow -->
    <div class="absolute inset-0 -z-10 pointer-events-none bg-black">
        <div class="absolute inset-0 z-10 bg-black/40"></div>
        <img id="hero-slide-1" src="{{ asset('images/bg-optimal-classes.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-100" style="transition: opacity 2500ms ease-in-out;" alt="Optimal Classes Slideshow 1">
        <img id="hero-slide-2" data-src="{{ asset('images/12.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-0" style="transition: opacity 2500ms ease-in-out;" alt="Optimal Classes Slideshow 2">
        <img id="hero-slide-3" data-src="{{ asset('images/14.webp') }}" class="absolute inset-0 w-full h-full object-cover opacity-0" style="transition: opacity 2500ms ease-in-out;" alt="Optimal Classes Slideshow 3">
    </div>

    <h1 class="text-5xl font-bold text-white mb-4">Welcome to <span class="text-white">Optimal Classes</span></h1>
    <p class="text-lg text-white/90 mb-8 max-w-2xl">Empowering students and teachers with a modern, efficient, and professional class management experience.</p>

    <div class="flex flex-wrap justify-center gap-4">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-[#2c3e80] text-white px-8 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-lg">Go to Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="bg-[#2c3e80] text-white px-8 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-lg">Login to Academy</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-white text-gray-700 border border-gray-300 px-8 py-3 rounded-lg hover:bg-gray-50 text-lg transition font-bold">Register Now</a>
                @endif
            @endauth
        @endif
    </div>


</div>

<div class="bg-white py-20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="text-center">
                <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Quality Education</h3>
                <p class="text-gray-500">Access top-tier resources and learning materials designed for excellence.</p>
            </div>
            <div class="text-center">
                <div class="bg-green-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Easy Management</h3>
                <p class="text-gray-500">Seamlessly track attendance, marks, and assignments in one place.</p>
            </div>
            <div class="text-center">
                <div class="bg-purple-50 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Real-time Timetables</h3>
                <p class="text-gray-500">Stay organized with live timetable updates and scheduling notifications.</p>
            </div>
        </div>
    </div>
</div>

<!-- Home Section -->
<section id="home" class="bg-[#2c3e80] text-white py-20">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Top Rated Coaching Institute in Varanasi, Uttar Pradesh</h1>
        <p class="text-lg md:text-xl mb-8 max-w-4xl mx-auto">Optimal Classes is a top rated educational institute in Varanasi offering result-oriented coaching for CBSE, ICSE/ISC, Olympiad, IIT JEE and NEET preparation.</p>

        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg> Class 6-12</span>
            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8V5a3 3 0 013-3h4a3 3 0 013 3v3a4 4 0 01-4 4H11a4 4 0 01-4-4z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21h6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/></svg> Board Exams</span>
            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg> Olympiad</span>
            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 11-4 4 4 4 0 014-4zm0 0v-3m0 12v-3m9-6h-3M6 12H3m15.364-6.364l-2.121 2.121M8.757 15.243l-2.121 2.121m0-10.607l2.121 2.121M15.243 15.243l2.121 2.121"/></svg> IIT JEE</span>
            <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.182l-7.682-7.682a4.5 4.5 0 010-6.364z"/></svg> NEET</span>
        </div>
    </div>
</section>

<!-- Why Choose Optimal Classes -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Why Choose Optimal Classes in Varanasi?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">At Optimal Classes, we focus on personalized learning, conceptual clarity, and result-driven preparation.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1M17 10a4 4 0 100-8 4 4 0 000 8zM7 10a4 4 0 100-8 4 4 0 000 8z"/></svg></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Experienced faculty members from top educational backgrounds</h3>
                <p class="text-gray-600">Our teachers bring years of expertise and proven teaching methodologies.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h6M7 15h6M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Regular tests and doubt-solving sessions</h3>
                <p class="text-gray-600">Continuous assessment and personalized doubt clearing for better understanding.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 18h8"/></svg></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Smart classrooms and interactive learning tools</h3>
                <p class="text-gray-600">Modern technology integrated with traditional teaching methods.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14a3 3 0 100-6H6"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17h10a2 2 0 100-4H7"/></svg></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Fully air-conditioned classrooms</h3>
                <p class="text-gray-600">Comfortable learning environment for focused studies.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4"><svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Comprehensive study material for CBSE, ICSE, and State Board</h3>
                <p class="text-gray-600">Complete coverage of all board syllabi with practice materials.</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="text-[#2c3e80] mb-4">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Strong focus on IIT JEE and NEET foundation building</h3>
                <p class="text-gray-600">Early preparation and conceptual clarity for competitive exams.</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 max-w-2xl mx-auto">
            <div class="text-center">
                <div class="text-4xl font-bold text-[#2c3e80] mb-0.5">6</div>
                <p class="text-gray-600 font-medium">Dedicated Teachers</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#2c3e80] mb-0.5">1000+</div>
                <p class="text-gray-600 font-medium">Students</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-[#2c3e80] mb-0.5">100+</div>
                <p class="text-gray-600 font-medium">Toppers</p>
            </div>
        </div>
    </div>
</section>

<!-- Student Testimonials -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What Our Students Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <p class="text-gray-600 italic">"Best Faculty for its optimal price and the effort made by the teachers... regular evaluation of results, competitive environment, and obviously, the skills are outstanding... definitely way to go"</p>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-800">Anas Siddqui</p>
                        <p class="text-sm text-gray-500">Scored 96% marks in Boards</p>
                    </div>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <p class="text-gray-600 italic">"I would like to express my sincere gratitude to optimal classes... Shobhit sir has been a great mentor. He is always helped me in my understanding of concepts, and he not only supports my academics but also motivated me to stay on course."</p>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-800">Niyati V. Singh</p>
                        <p class="text-sm text-gray-500">Scored 93.5% marks in Boards</p>
                    </div>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <p class="text-gray-600 italic">"Really having a good service by the tutorial staff here. I am provided with excellent support great knowledge by Shobhit Sir. His teaching is simple yet incredibly powerful. Highly recommended."</p>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-bold text-gray-800">Sakshi Srivastava</p>
                        <p class="text-sm text-gray-500">Scored 93% marks in Boards</p>
                    </div>
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Courses & Fee Section -->
<section id="courses" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Our Coaching Programs</h2>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Choose the right program for your child with focused coaching for boards, competitive exams, and early foundation.</p>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">Class 6 to 10 — CBSE, ICSE and ISC Coaching</h3>
        <p class="text-gray-600 mb-6 flex-1">Comprehensive coaching focusing on concept clarity, NCERT coverage and exam-oriented preparation.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">PCM & PCB Coaching</h3>
        <p class="text-gray-600 mb-6 flex-1">Expert guidance in Physics, Chemistry, Mathematics and Biology for Class 11 and 12.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">IIT JEE Coaching in Varanasi</h3>
        <p class="text-gray-600 mb-6 flex-1">Structured preparation for JEE Main and Advanced with advanced problem-solving techniques and regular mock tests.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 20.182l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">NEET Coaching in Varanasi</h3>
        <p class="text-gray-600 mb-6 flex-1">Result-driven NEET coaching with experienced biology faculty and regular assessments.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">ICSE / ISC Coaching</h3>
        <p class="text-gray-600 mb-6 flex-1">Strong academic foundation for ICSE and ISC science students with comprehensive study material.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 max-w-sm mx-auto">
        <div class="flex justify-center mb-4">
            <svg class="w-10 h-10 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-3">Foundation & Pre-Foundation Classes</h3>
        <p class="text-gray-600 mb-6 flex-1">Help students build strong fundamentals from an early stage for future competitive exams.</p>
        <a href="{{ route('courses') }}" class="bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold">Enquire Now</a>
    </div>
</div>

        <div class="bg-[#f8fafc] rounded-3xl border border-gray-200 p-8 mb-16">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-8">
                    <h3 class="text-3xl font-bold text-gray-900 tracking-tight">Serving students across Varanasi</h3>
                    <p class="text-gray-600 mt-3 text-base">Our coaching centers and services are easily accessible from the following prime locations.</p>
                </div>
                <div class="flex flex-wrap justify-center gap-3">
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>BLW</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Sunderpur</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Susuwahi</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Bajardhia</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Chitaipur</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Manduwadih</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Lahartara</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Lanka</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Naria</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Bhelupur</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Khojwan</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Durgakund</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Shivpur</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Kakarmatta</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Bhagwanpur</span>
                    </div>
                    <div class="inline-flex items-center bg-white border border-gray-200 rounded-full px-4 py-2 shadow-sm text-sm font-medium text-gray-800">
                        <svg class="w-4 h-4 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Varanasi Cantonment</span>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-500 mt-8">If you&apos;re searching for "best coaching classes in Varanasi" or "coaching institute in Varanasi", you&apos;ll find Optimal Classes conveniently located and ready to help.</p>
            </div>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = [
            document.getElementById('hero-slide-1'),
            document.getElementById('hero-slide-2'),
            document.getElementById('hero-slide-3')
        ];
        
        let currentIndex = 0;
        
        // Lazy load images 2 and 3 after window load event
        window.addEventListener('load', function() {
            setTimeout(function() {
                for (let i = 1; i < slides.length; i++) {
                    if (slides[i] && slides[i].hasAttribute('data-src')) {
                        slides[i].setAttribute('src', slides[i].getAttribute('data-src'));
                        slides[i].removeAttribute('data-src');
                    }
                }
            }, 1000); // 1 second delay to ensure other page content loads first
        });

        function showNextSlide() {
            const nextIndex = (currentIndex + 1) % slides.length;
            const currentSlide = slides[currentIndex];
            const nextSlide = slides[nextIndex];
            
            if (!currentSlide || !nextSlide) return;

            // Ensure the next image is loaded before transition
            if (nextSlide.hasAttribute('data-src')) {
                nextSlide.setAttribute('src', nextSlide.getAttribute('data-src'));
                nextSlide.removeAttribute('data-src');
            }

            // Perform crossfade transition
            currentSlide.classList.remove('opacity-100');
            currentSlide.classList.add('opacity-0');
            nextSlide.classList.remove('opacity-0');
            nextSlide.classList.add('opacity-100');
            
            currentIndex = nextIndex;
        }

        // Run auto-advance every 5 seconds (5000ms)
        setInterval(showNextSlide, 5000);
    });
</script>

@endsection
