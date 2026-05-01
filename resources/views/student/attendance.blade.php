@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- View Attendance (Active) -->
    <a href="{{ route('student.attendance') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">My Attendance</h1>
    <p class="text-sm text-gray-500">View and filter your attendance history.</p>
</div>

<!-- Summary Cards Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Days -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-purple-500">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Days</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $summary['total'] }}</p>
    </div>

    <!-- Present -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-green-500">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Present</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $summary['present'] }}</p>
    </div>

    <!-- Absent -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-red-500">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Absent</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $summary['absent'] }}</p>
    </div>

    <!-- Attendance % -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500">
        <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Attendance %</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $summary['percentage'] }}%</p>
        
        @php
            $percent = (float) $summary['percentage'];
            $progressColor = $percent >= 75 ? 'bg-green-500' : ($percent >= 50 ? 'bg-yellow-500' : 'bg-red-500');
        @endphp
        <!-- Progress Bar -->
        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3">
            <div class="{{ $progressColor }} h-1.5 rounded-full" style="width: {{ min($percent, 100) }}%"></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('student.attendance') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-grow min-w-[200px]">
            <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Select Month</label>
            <select name="month" id="month" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $selected_month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex-grow min-w-[200px]">
            <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Select Year</label>
            <select name="year" id="year" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                @foreach(range(date('Y') - 1, date('Y') + 1) as $y)
                    <option value="{{ $y }}" {{ $selected_year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-[42px]">
            Filter Records
        </button>
    </form>
</div>

<!-- Attendance Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($attendance->isEmpty())
        <div class="p-20 text-center">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
            <p class="text-gray-400 font-medium italic">No attendance records found for this period.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Day of Week</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marked By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($attendance as $record)
                    @php
                        $statusBadge = match($record->status) {
                            'present' => 'bg-green-100 text-green-700',
                            'absent' => 'bg-red-100 text-red-700',
                            'late' => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-gray-100 text-gray-700'
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($record->date)->format('l') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusBadge }}">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $record->marker->name ?? 'System' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $attendance->appends(['month' => $selected_month, 'year' => $selected_year])->links() }}
        </div>
    @endif
</div>
@endsection
