@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard (Active) -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- Mark Attendance -->
    <a href="{{ route('teacher.attendance') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
        Mark Attendance
    </a>
    
    <!-- Upload Marks -->
    <a href="{{ route('teacher.marks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        Upload Marks
    </a>
    
    <!-- Add Remark -->
    <a href="{{ route('teacher.remarks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
        Add Remark
    </a>
    
    <!-- My Students -->
    <a href="{{ route('teacher.students') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        My Students
    </a>
    
    <!-- Assignments -->
    <a href="{{ route('teacher.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Assignments
    </a>
    
    <!-- Timetable -->
    <a href="{{ route('teacher.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Timetable
    </a>
@endpush

@section('content')
<!-- Welcome Banner -->
<div class="mb-8 bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ $teacher->user->name }}</h1>
        <p class="text-gray-500 mt-1 font-medium">{{ $teacher->subject }} Teacher</p>
    </div>
    <div class="text-right">
        <p class="text-lg font-semibold text-[#2c3e80]">{{ now()->toFormattedDateString() }}</p>
        <p class="text-sm text-gray-400 capitalize">{{ now()->format('l') }}</p>
    </div>
</div>





<!-- Quick Actions -->
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Mark Attendance -->
        <a href="{{ route('teacher.attendance') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md hover:border-[#2c3e80]">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-1">Mark Attendance</h4>
            <p class="text-sm text-gray-500">Record student presence for your class today.</p>
        </a>

        <!-- Upload Marks -->
        <a href="{{ route('teacher.marks') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md hover:border-[#2c3e80]">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-1">Upload Marks</h4>
            <p class="text-sm text-gray-500">Enter exam and test results for your students.</p>
        </a>

        <!-- Add Remark -->
        <a href="{{ route('teacher.remarks') }}" class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md hover:border-[#2c3e80]">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-1">Add Remark</h4>
            <p class="text-sm text-gray-500">Write constructive feedback for a specific student.</p>
        </a>
    </div>
</div>

<!-- Today's Schedule -->
<div>
    <h3 class="text-lg font-bold text-gray-800 mb-4">Today's Schedule</h3>
    <div class="space-y-4">
        @forelse($today_timetable as $entry)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-[#2c3e80] flex flex-col md:flex-row md:items-center justify-between gap-4 transition hover:bg-gray-50">
                <div class="flex items-center gap-4">
                    <div class="bg-gray-50 px-4 py-2 rounded-lg text-center min-w-[120px]">
                        <p class="text-xs font-bold text-[#2c3e80] uppercase tracking-wide">Time Slot</p>
                        <p class="text-sm font-bold text-gray-700">
                            {{ \Carbon\Carbon::parse($entry->time_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($entry->time_end)->format('h:i A') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-800">{{ $entry->academicClass->name ?? 'N/A' }}</h4>
                        <p class="text-sm text-gray-500">{{ $entry->subject }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-blue-50 text-[#2c3e80] text-xs font-bold rounded-full uppercase tracking-tighter">In Progress</span>
                </div>
            </div>
        @empty
            <div class="py-12 text-center bg-white rounded-xl border border-gray-100">
                <p class="text-gray-400 font-medium italic">No classes scheduled today.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
