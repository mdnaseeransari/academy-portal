@extends('layouts.public')
@section('title', 'About Optimal Classes | Director, Vision & Academic Team | Varanasi')
@section('meta_description', 'Meet Shobhit Kumar Srivastava, B.Tech HBTI Kanpur, Director of Optimal Classes Varanasi. Expert faculty for Class 6-12, IIT-JEE and NEET coaching near Kakarmatta.')
@section('meta_keywords', 'optimal classes director varanasi, shobhit srivastava coaching varanasi, about optimal classes kakarmatta')

@section('content')
<!-- About Us Page Content -->
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <!-- Director Section -->
        <div class="mb-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Our Director</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Shobhit Kumar Srivastava</h3>
                    <p class="text-[#2c3e80] font-medium mb-6">Director, B.Tech from H.B.T.I Kanpur (Mechanical Engineering)</p>
                    <p class="text-gray-600 leading-relaxed mb-6">Shobhit Kumar Srivastava, the esteemed director of Optimal Classes, is a visionary leader dedicated to transforming the field of education. He earned his B. Tech. degree in 2007 from H. B. T. I. Kanpur, one of India's most prestigious engineering colleges. Before embarking on his journey as an educator, Mr. Srivastava built a remarkable career as a senior engineer at Larsen & Toubro (L&T) and Hindustan Construction Company (HCC) from 2007 to 2017. Driven by a profound desire to serve the nation, he transitioned to education in 2017 and has been passionately committed to nurturing young minds ever since.</p>
                    <p class="text-gray-500 italic">Warm regards, Shobhit Kumar Srivastava, Director</p>
                </div>
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-[#2c3e80] to-[#B8924A] rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <img src="{{ asset('images/Shobhit Srivastava.webp') }}" class="relative rounded-2xl shadow-xl w-full h-[400px] object-contain bg-white" alt="Shobhit Kumar Srivastava" loading="lazy">
                </div>
            </div>
        </div>

        <!-- Vision and Mission -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="bg-[#2c3e80] text-white p-8 rounded-xl">
                <h3 class="text-2xl font-bold mb-4">Our Vision</h3>
                <p class="text-white/90 leading-relaxed">To empower students through high-quality digital education, fostering easy understanding with the guidance of highly qualified and experienced tutors.</p>
            </div>
            <div class="bg-white border-2 border-[#2c3e80] p-8 rounded-xl">
                <h3 class="text-2xl font-bold text-[#2c3e80] mb-4">Our Mission</h3>
                <p class="text-gray-700 leading-relaxed">To be a leading provider of innovative digital education that transforms learning into an engaging, accessible, and effective journey.</p>
            </div>
        </div>

        <!-- Academic Team -->
        <div class="mb-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Our Academic Team</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Shobhit Srivastava.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Shobhit Srivastava" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Shobhit Srivastava</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Maths</span>
                    <p class="text-[10px] text-gray-500 mt-1">B.Tech HBTI Kanpur, 7+ years</p>
                </div>
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Rahul Pandey.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Rahul Pandey" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Rahul Pandey</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Physics</span>
                    <p class="text-[10px] text-gray-500 mt-1">M.Sc. Physics, 10+ years</p>
                </div>
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Vaibhav Singh.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Vaibhav Singh" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Vaibhav Singh</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Chemistry</span>
                    <p class="text-[10px] text-gray-500 mt-1">M.Sc. Chemistry, 6+ years</p>
                </div>
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Ms.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Ms. Shalini" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Ms. Shalini</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">English</span>
                    <p class="text-[10px] text-gray-500 mt-1">Masters from BHU, 2+ years</p>
                </div>
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Sahil Ali.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Sahil Ali" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Sahil Ali</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Science</span>
                    <p class="text-[10px] text-gray-500 mt-1">B.Tech, 4+ years</p>
                </div>
                <div class="text-center group">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <img src="{{ asset('images/Anuj Yadav.webp') }}" class="w-full h-full rounded-full object-cover shadow-md group-hover:shadow-xl group-hover:scale-105 transition-all duration-300 border-2 border-white" alt="Anuj Yadav" loading="lazy">
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm">Anuj Yadav</h4>
                    <span class="bg-[#2c3e80] text-white text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider">Biology</span>
                    <p class="text-[10px] text-gray-500 mt-1">M.Sc. Botany, 5+ years</p>
                </div>
            </div>
        </div>

        <!-- Student's Journey -->
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Student's Journey Inside Optimal Classes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Digital Classrooms</h4>
                    </div>
                    <p class="text-gray-600">Our classrooms are equipped with state-of-the-art technology to provide a dynamic and interactive learning experience through multimedia tools.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Focus on Critical Thinking</h4>
                    </div>
                    <p class="text-gray-600">We emphasize conceptual understanding and critical thinking skills to prepare students for academic and real-world challenges.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Balanced Preparation</h4>
                    </div>
                    <p class="text-gray-600">Our curriculum is designed to balance board exam preparation with competitive exams like IIT-JEE and NEET, ensuring success in both.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Proven Track Record</h4>
                    </div>
                    <p class="text-gray-600">With a proven track record of excellence, our students consistently achieve outstanding results, solidifying our reputation as a trusted leader in education.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Regular Assessments</h4>
                    </div>
                    <p class="text-gray-600">Weekly tests conducted every Sunday help track student progress, identify areas of improvement, and ensure exam readiness.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Customized Study Material</h4>
                    </div>
                    <p class="text-gray-600">Our in-house experts create study materials tailored to simplify complex topics while aligning with the latest syllabus.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Worksheets for Every Chapter</h4>
                    </div>
                    <p class="text-gray-600">Every chapter is supplemented with worksheets to ensure students thoroughly understand and practice each topic.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-[#2c3e80]/10 text-[#2c3e80] rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#2c3e80]">Doubt Clarification Sessions</h4>
                    </div>
                    <p class="text-gray-600">Dedicated sessions address individual queries, ensuring no student is left behind and all doubts are clarified.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection