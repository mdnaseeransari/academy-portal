@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- Mark Attendance (Active) -->
    <a href="{{ route('teacher.attendance') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
    <a href="{{ route('teacher.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('teacher.assignments*') ? 'text-white bg-white/20 font-medium' : 'text-white/80 hover:text-white hover:bg-white/10' }} rounded-lg mx-2 text-sm transition">
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
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Mark Student Attendance</h1>
    <p class="text-sm text-gray-500">Select class and date to record daily presence.</p>
</div>

<!-- Top Filter Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('teacher.attendance') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-grow min-w-[200px]">
            <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Select Date</label>
            <input type="date" id="date" name="date" value="{{ $selected_date ?? date('Y-m-d') }}"
                   class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
        </div>

        <div class="flex-grow min-w-[200px]">
            <label for="class_id" class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" id="class_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                <option value="">-- Choose Class --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-[42px]">
            Load Students
        </button>
    </form>

    @if($selected_date && $selected_date > date('Y-m-d'))
        <div class="mt-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg p-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <p class="text-sm font-medium">Note: You are marking attendance for a future date.</p>
        </div>
    @endif
</div>

@php $editing = request('edit') == '1'; @endphp
@if($students->isNotEmpty() && (!$already_marked || $editing))
    <!-- Marking Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <button type="button" onclick="document.querySelectorAll('input[value=\'present\']').forEach(r => r.checked = true)" 
                        class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition font-bold text-xs flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Select All Present
                </button>
                <span class="text-sm text-gray-500 font-medium italic">{{ count($students) }} Students Loaded</span>
            </div>
        </div>

        <form action="{{ route('teacher.attendance.mark') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $selected_class }}">
            <input type="hidden" name="date" value="{{ $selected_date }}">

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Note (Optional)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800">{{ $student->roll_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-800">{{ $student->user->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-1 cursor-pointer group">
                                        <input type="radio" name="attendance[{{ $student->id }}][status]" value="present" 
                                               {{ (!isset($existing_attendance[$student->id]) || $existing_attendance[$student->id]->status == 'present') ? 'checked' : '' }}
                                               class="accent-green-500 w-4 h-4 border-gray-300 focus:ring-green-500">
                                        <span class="text-xs font-bold text-gray-600 group-hover:text-green-600 transition">Present</span>
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer group">
                                        <input type="radio" name="attendance[{{ $student->id }}][status]" value="absent" 
                                               {{ (isset($existing_attendance[$student->id]) && $existing_attendance[$student->id]->status == 'absent') ? 'checked' : '' }}
                                               class="accent-red-500 w-4 h-4 border-gray-300 focus:ring-red-500">
                                        <span class="text-xs font-bold text-gray-600 group-hover:text-red-600 transition">Absent</span>
                                    </label>
                                    <label class="flex items-center gap-1 cursor-pointer group">
                                        <input type="radio" name="attendance[{{ $student->id }}][status]" value="late" 
                                               {{ (isset($existing_attendance[$student->id]) && $existing_attendance[$student->id]->status == 'late') ? 'checked' : '' }}
                                               class="accent-yellow-500 w-4 h-4 border-gray-300 focus:ring-yellow-500">
                                        <span class="text-xs font-bold text-gray-600 group-hover:text-yellow-600 transition">Late</span>
                                    </label>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="attendance[{{ $student->id }}][note]" placeholder="Optional note..."
                                       class="w-full border-gray-200 rounded-lg text-xs py-1.5 focus:ring-[#2c3e80] focus:border-[#2c3e80]">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-100 text-right">
                <button type="submit" class="bg-[#2c3e80] text-white px-10 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-md">
                    Save Attendance
                </button>
            </div>
        </form>
    </div>

@elseif($already_marked)
    <!-- Read-only View -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 bg-yellow-50 border-b border-yellow-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-yellow-800">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <p class="text-sm font-bold">Attendance already marked for this date. Showing existing records.</p>
            </div>
            <a href="?edit=1&date={{ $selected_date }}&class_id={{ $selected_class }}" 
               class="bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition font-bold text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Attendance
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marked At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($existing_attendance as $record)
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
                            <span class="text-sm font-bold text-gray-800">{{ $record->student->roll_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">{{ $record->student->user->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusBadge }}">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400 italic">
                            {{ $record->created_at->format('h:i A') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@else
    <!-- Empty State -->
    <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <p class="text-gray-400 font-medium italic">Select a class and date above to load students.</p>
    </div>
@endif
@endsection
