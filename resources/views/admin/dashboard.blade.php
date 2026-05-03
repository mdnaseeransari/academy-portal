@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard (Active) -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- Students -->
    <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        Students
    </a>
    
    <!-- Teachers -->
    <a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        Teachers
    </a>
    
    <!-- Reports -->
    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Reports
    </a>
    
    <!-- Timetable -->
    <a href="{{ route('admin.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
        Timetable
    </a>
    
    <!-- Messages -->
    <a href="{{ route('admin.contacts') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        Messages
    </a>
@endpush

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
    <p class="text-sm text-gray-500 font-medium">System overview and management console.</p>
</div>

<!-- Stats Row 1 -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Students</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['students']) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-green-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Teachers</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['teachers']) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-purple-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Classes</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['classes']) }}</p>
    </div>
</div>

<!-- Stats Row 2 -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-teal-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Today's Attendance %</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['attendance_today'] }}%</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-red-500 relative">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Unread Messages</p>
        <div class="flex items-center gap-2 mt-1">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['unread_contacts'] }}</p>
            @if($stats['unread_contacts'] > 0)
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                </span>
            @endif
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-orange-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Assignments This Week</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['assignments'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
    <!-- Attendance Overview -->
    <div class="lg:col-span-3">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Today's Attendance Overview</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Class Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Present</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Absent</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Late</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Total</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attendance_overview as $item)
                        @php
                            $percentage = $item['percentage'] ?? 0;
                            $badgeColor = $percentage >= 75 ? 'bg-green-100 text-green-700' : ($percentage >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800 text-sm">{{ $item['class_name'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-green-600">{{ $item['present'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-red-600">{{ $item['absent'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-yellow-600">{{ $item['late'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-500">{{ $item['total'] }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeColor }}">
                                    {{ $percentage }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400 italic text-sm">No attendance recorded today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Students</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="space-y-6">
                @forelse($recent_students as $student)
                <div class="flex items-center justify-between pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $student->user->name }}</p>
                        <p class="text-xs text-gray-400 font-medium mt-1">{{ $student->academicClass->name ?? 'Unassigned' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">
                            {{ \Carbon\Carbon::parse($student->created_at)->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 italic text-sm py-4">No recent registrations.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Unread Messages</h3>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Message Preview</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_contacts as $contact)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 italic">"{{ Str::limit($contact->message, 50) }}"</td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">
                            {{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Unread</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.contacts.read', $contact->id) }}">
                                @csrf
                                <button type="submit" class="bg-[#2c3e80] text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                                    Mark Read
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">No unread messages.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Links</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <a href="/admin/students" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Add Student</p>
        </a>
        <a href="/admin/teachers" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Add Teacher</p>
        </a>
        <a href="/admin/reports" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">View Reports</p>
        </a>
        <a href="/admin/timetable" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Timetable</p>
        </a>
        <a href="/admin/contacts" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">All Messages</p>
        </a>
    </div>
</div>
@endsection
