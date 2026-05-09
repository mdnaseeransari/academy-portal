@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- View Attendance -->
    <a href="{{ route('student.attendance') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
        View Attendance
    </a>
    
    <!-- View Marks -->
    <a href="{{ route('student.marks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        View Marks
    </a>
    
    <!-- Assignments -->
    <a href="{{ route('student.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        Assignments
    </a>
    
    <!-- Remarks -->
    <a href="{{ route('student.remarks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
        Remarks
    </a>
    
    <!-- Timetable -->
    <a href="{{ route('student.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Timetable
    </a>
    
    <!-- Contact Us (Active) -->
    <a href="{{ route('student.contact') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact Us
    </a>
@endpush

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Contact Support</h1>
    <p class="text-sm text-gray-500">Need help? Send us a message and we'll get back to you.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <!-- Left Column: Contact Form -->
    <div class="lg:col-span-3">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('student.contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Your Name</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" readonly 
                               class="w-full bg-gray-50 border-gray-200 rounded-lg text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-200">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" readonly 
                               class="w-full bg-gray-50 border-gray-200 rounded-lg text-gray-500 cursor-not-allowed focus:ring-0 focus:border-gray-200">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number (Optional)</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="10 Digit Mobile Number"
                               minlength="10" maxlength="10" pattern="[0-9]{10}"
                               class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] transition">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" placeholder="Reason for contact" required
                               class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] transition">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required
                              class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] transition">{{ old('message') }}</textarea>
                    @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-[#2c3e80] text-white py-3 px-6 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-sm">
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Info Cards -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Contact Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6 pb-2 border-b border-gray-50">Contact Information</h3>
            
            <div class="space-y-6">
                <div class="flex items-start gap-4">
                    <div class="mt-1 text-[#2c3e80]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Address</p>
                        <p class="text-sm text-gray-500 leading-relaxed">Optimal Classes, 123 Education Hub, New Delhi, India</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="mt-1 text-[#2c3e80]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Phone</p>
                        <p class="text-sm text-gray-500">+91 98765 43210</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="mt-1 text-[#2c3e80]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Email</p>
                        <p class="text-sm text-gray-500">support@optimalclasses.com</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="mt-1 text-[#2c3e80]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Working Hours</p>
                        <p class="text-sm text-gray-500">Mon–Sat, 8:00 AM – 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Tips Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM5.884 6.607a1 1 0 01-.226 1.394l-1.1 1.1a1 1 0 01-1.394-1.414l1.1-1.1a1 1 0 011.62.02zM14.116 6.607a1 1 0 011.62-.02l1.1 1.1a1 1 0 01-1.394 1.414l-1.1-1.1a1 1 0 01.226-1.394zM12 11a2 2 0 11-4 0 2 2 0 014 0zM7 13a5 5 0 005 5h1a1 1 0 100-2h-1a3 3 0 01-3-3V7a1 1 0 10-2 0v6z"></path></svg>
                Quick Tips
            </h3>
            <ul class="space-y-3">
                <li class="text-sm text-gray-500 flex items-start gap-2">
                    <span class="text-[#2c3e80] mt-1">•</span>
                    We typically respond within 24 hours.
                </li>
                <li class="text-sm text-gray-500 flex items-start gap-2">
                    <span class="text-[#2c3e80] mt-1">•</span>
                    For urgent matters, call directly.
                </li>
                <li class="text-sm text-gray-500 flex items-start gap-2">
                    <span class="text-[#2c3e80] mt-1">•</span>
                    Include your roll number in the message.
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
