@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard (Active) -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
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
    
    <!-- Contact Us -->
    <a href="{{ route('student.contact') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        Contact Us
    </a>
@endpush

@section('content')
<!-- Welcome Banner -->
<div class="mb-8 bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Welcome back, {{ $student->user->name }}</h1>
        <p class="text-gray-500 mt-1">Here's your academic performance summary for today.</p>
    </div>
    <div class="text-right">
        <p class="text-lg font-semibold text-[#2c3e80]">{{ now()->toFormattedDateString() }}</p>
        <p class="text-sm text-gray-400 capitalize">{{ now()->format('l') }}</p>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Time Table -->
    <a href="{{ route('student.timetable') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-[#2c3e80] hover:shadow-md transition group">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide group-hover:text-[#2c3e80] transition">Time Table</p>
        <div class="mt-1">
            @if($stats['current_class'])
                <p class="text-xl font-bold text-gray-800 leading-tight">{{ $stats['current_class']->subject }}</p>
                <p class="text-xs text-gray-400 font-bold uppercase mt-1">{{ \Carbon\Carbon::parse($stats['current_class']->time_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($stats['current_class']->time_end)->format('h:i A') }}</p>
            @elseif($stats['next_class'])
                <p class="text-xl font-bold text-gray-800 leading-tight">{{ $stats['next_class']->subject }}</p>
                <p class="text-xs text-gray-400 font-bold uppercase mt-1">{{ \Carbon\Carbon::parse($stats['next_class']->time_start)->format('h:i A') }}</p>
            @else
                <p class="text-xl font-bold text-gray-400 italic leading-tight">No more classes</p>
                <p class="text-xs text-gray-300 font-bold uppercase mt-1">Today</p>
            @endif
        </div>
    </a>

    <!-- Total Aggregate Marks -->
    <a href="{{ route('student.marks') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-purple-500 hover:shadow-md transition group">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide group-hover:text-purple-600 transition">Total Score</p>
        <div class="flex items-baseline gap-1 mt-1">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_obtained'] }}</p>
            <p class="text-sm font-bold text-gray-400">/ {{ $stats['total_possible'] }}</p>
        </div>
        <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Cumulative Marks</p>
    </a>

    <!-- Attendance % -->
    <a href="{{ route('student.attendance') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500 hover:shadow-md transition group">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide group-hover:text-blue-600 transition">Attendance %</p>
        <div class="flex items-center justify-between mt-1 mb-2">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['percentage'] }}%</p>
        </div>
        <!-- Progress Bar -->
        <div class="w-full bg-gray-100 rounded-full h-2">
            <div class="bg-[#2c3e80] h-2 rounded-full" style="width: {{ $stats['percentage'] }}%"></div>
        </div>
    </a>

    <!-- Pending Assignments -->
    <a href="{{ route('student.assignments') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-yellow-500 hover:shadow-md transition group">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide group-hover:text-yellow-600 transition">Pending Tasks</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_assignments'] }}</p>
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Marks Table -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800">Recent Marks</h3>
                <a href="{{ route('student.marks') }}" class="text-sm text-[#2c3e80] font-semibold hover:underline">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Exam Type</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentMarks as $mark)
                        @php
                            $percentage = $mark->total_marks > 0 ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
                            $badgeClass = $percentage >= 75 ? 'bg-green-100 text-green-700' : ($percentage >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-gray-800">{{ $mark->subject }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $mark->exam_type) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800">{{ $mark->marks_obtained }}/{{ $mark->total_marks }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                    {{ number_format($percentage, 0) }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400 italic">No marks recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Remarks -->
    <div class="space-y-6">
        <h3 class="text-lg font-bold text-gray-800 px-2">Teacher Remarks</h3>
        @forelse($recentRemarks as $remark)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
            <!-- Decorative accent -->
            <div class="absolute top-0 right-0 w-2 h-full bg-[#2c3e80]/10"></div>
            
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-[#2c3e80] text-white flex items-center justify-center font-bold text-sm">
                    {{ substr($remark->teacher->name ?? 'T', 0, 1) }}
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-800">{{ $remark->teacher->name ?? 'Teacher' }}</h4>
                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($remark->date)->format('M d, Y') }}</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 italic leading-relaxed">
                "{{ $remark->remark_text }}"
            </p>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
            <p class="text-sm text-gray-400 italic">No remarks from teachers yet.</p>
        </div>
        @endforelse
        
        <a href="{{ route('student.remarks') }}" class="block text-center py-3 bg-gray-50 text-gray-600 rounded-xl border border-dashed border-gray-300 hover:bg-gray-100 transition text-sm font-medium">
            View All Remarks
        </a>
    </div>
</div>
@endsection
