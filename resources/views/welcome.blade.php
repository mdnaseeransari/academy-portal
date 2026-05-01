@extends('layouts.public')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center text-center px-6">
    <h1 class="text-5xl font-bold text-gray-800 mb-4">Welcome to <span class="text-[#2c3e80]">Optimal Classes</span></h1>
    <p class="text-lg text-gray-500 mb-8 max-w-2xl">Empowering students and teachers with a modern, efficient, and professional class management experience.</p>
    
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
@endsection
