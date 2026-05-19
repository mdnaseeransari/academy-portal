@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manage Attendance</h1>
        <p class="text-sm text-gray-500">View and directly record attendance records for any class, date, and period.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Shared Class Filter & Options -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('admin.attendance') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                @if($classes->isEmpty())
                    <option value="">No classes available</option>
                @endif
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Date</label>
            <input type="date" name="date" value="{{ $selected_date }}" required max="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
        </div>

        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-[42px]">
            Load Records
        </button>
    </form>
</div>

@if($selected_class_id)
    <!-- Daily History Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Attendance History for {{ \Carbon\Carbon::parse($selected_date)->format('M d, Y') }}</h3>
        </div>
        
        <div class="p-6">
            @if(isset($available_slots) && $available_slots->isEmpty() && (!isset($scheduled_slots) || $scheduled_slots->isEmpty()))
                <p class="text-gray-500 italic mb-4">No attendance records or scheduled classes found for this date.</p>
            @endif

            @if(isset($scheduled_slots) && $scheduled_slots->isNotEmpty())
                <div class="mb-8">
                    <h4 class="text-[10px] font-bold text-[#2c3e80] uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                        Scheduled Timetable Sessions
                    </h4>
                    <div class="flex flex-wrap gap-3">
                        @foreach($scheduled_slots as $schedule)
                            @php 
                                $slotName = $schedule->subject . ' ' . \Carbon\Carbon::parse($schedule->time_start)->format('H:i') . '-' . \Carbon\Carbon::parse($schedule->time_end)->format('H:i'); 
                                $isMarked = isset($available_slots) && $available_slots->contains('period_slot', $slotName);
                            @endphp
                            <a href="{{ route('admin.attendance', ['class_id' => $selected_class_id, 'date' => $selected_date, 'period_slot' => $slotName]) }}" 
                               class="inline-flex flex-col gap-1 px-4 py-3 rounded-xl border {{ $period_slot === $slotName ? 'bg-[#2c3e80] text-white border-[#2c3e80] shadow-md' : ($isMarked ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' : 'bg-white text-gray-700 border-gray-200 hover:border-[#2c3e80] hover:shadow-sm') }} transition-all min-w-[140px]">
                                <span class="text-sm font-bold">{{ $schedule->subject }}</span>
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs opacity-80">{{ \Carbon\Carbon::parse($schedule->time_start)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->time_end)->format('h:i A') }}</span>
                                    @if($isMarked)
                                        <svg class="w-4 h-4 {{ $period_slot === $slotName ? 'text-white' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($available_slots) && $available_slots->isNotEmpty())
                <div>
                    <h4 class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-3">All Recorded Sessions</h4>
                    <div class="flex flex-col gap-3 mb-6">
                        @foreach($available_slots as $slot)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-[#2c3e80] transition {{ $period_slot == $slot->period_slot ? 'ring-2 ring-[#2c3e80]' : '' }}">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">Slot / Subject: <span class="text-[#2c3e80]">{{ $slot->period_slot }}</span></p>
                                    <div class="flex items-center gap-3 mt-1">
                                        <p class="text-xs text-gray-500">Marked at: {{ \Carbon\Carbon::parse($slot->created_at)->format('h:i A') }}</p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-200 px-2 py-0.5 rounded-sm">Marked by: {{ $slot->markedBy->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.attendance', ['class_id' => $selected_class_id, 'date' => $selected_date, 'period_slot' => $slot->period_slot]) }}" 
                                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-100 transition shadow-sm">
                                        View / Edit
                                    </a>
                                    <form action="{{ route('admin.attendance.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all attendance records for this session?')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                                        <input type="hidden" name="date" value="{{ $selected_date }}">
                                        <input type="hidden" name="period_slot" value="{{ $slot->period_slot }}">
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-bold hover:bg-red-600 transition shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr class="my-6 border-gray-100">

            <form action="{{ route('admin.attendance') }}" method="GET" class="flex gap-4 items-end" onsubmit="document.getElementById('period_slot_hidden').value = document.getElementById('subject_name').value + ' ' + document.getElementById('start_time').value + '-' + document.getElementById('end_time').value;">
                <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                <input type="hidden" name="date" value="{{ $selected_date }}">
                <input type="hidden" name="period_slot" id="period_slot_hidden">
                <div class="w-full max-w-3xl">
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Create New Session</label>
                    <div class="flex items-center gap-3">
                        <input type="text" id="subject_name" required placeholder="Subject Name (e.g. Physics)" class="flex-grow border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] h-[42px]">
                        <input type="time" id="start_time" required title="Start Time" class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] h-[42px]">
                        <span class="text-gray-400 font-bold">-</span>
                        <input type="time" id="end_time" required title="End Time" class="w-32 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] h-[42px]">
                        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-[42px] whitespace-nowrap">
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($period_slot)
        @if($students->isEmpty())
            <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 font-medium italic">No students found in this class.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="roster">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Student Attendance Roster</h3>
                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">
                            Date: <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($selected_date)->format('M d, Y') }}</span> | 
                            Slot: <span class="font-bold text-gray-800">{{ $period_slot }}</span>
                        </p>
                    </div>
                    @if($already_marked)
                        <span class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                            Editing Existing Records
                        </span>
                    @else
                        <span class="bg-green-100 text-green-800 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                            New Attendance Entry
                        </span>
                    @endif
                </div>

                <form action="{{ route('admin.attendance.mark') }}" method="POST">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                    <input type="hidden" name="date" value="{{ $selected_date }}">
                    <input type="hidden" name="period_slot" value="{{ $period_slot }}">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Attendance Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($students as $student)
                                    @php
                                        $currentStatus = 'present'; // default
                                        if ($already_marked && isset($existing_attendance[$student->id])) {
                                            $currentStatus = $existing_attendance[$student->id]->status;
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-bold text-gray-800 text-sm">{{ $student->roll_number }}</td>
                                        <td class="px-6 py-4 text-sm font-medium">{{ $student->user->name }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-6">
                                                <label class="flex items-center gap-2 cursor-pointer group">
                                                    <input type="radio" name="attendance[{{ $student->id }}][status]" value="present" 
                                                        {{ $currentStatus == 'present' ? 'checked' : '' }}
                                                        class="w-4 h-4 text-green-600 focus:ring-green-500 border-gray-300">
                                                    <span class="text-sm font-bold text-gray-700 group-hover:text-green-600 transition">Present</span>
                                                </label>
                                                
                                                <label class="flex items-center gap-2 cursor-pointer group">
                                                    <input type="radio" name="attendance[{{ $student->id }}][status]" value="absent" 
                                                        {{ $currentStatus == 'absent' ? 'checked' : '' }}
                                                        class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300">
                                                    <span class="text-sm font-bold text-gray-700 group-hover:text-red-600 transition">Absent</span>
                                                </label>
                                                
                                                <label class="flex items-center gap-2 cursor-pointer group">
                                                    <input type="radio" name="attendance[{{ $student->id }}][status]" value="late" 
                                                        {{ $currentStatus == 'late' ? 'checked' : '' }}
                                                        class="w-4 h-4 text-yellow-600 focus:ring-yellow-500 border-gray-300">
                                                    <span class="text-sm font-bold text-gray-700 group-hover:text-yellow-600 transition">Late</span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-6 bg-gray-50 border-t border-gray-100 text-right">
                        <button type="submit" class="bg-[#2c3e80] text-white px-8 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold shadow-md">
                            {{ $already_marked ? 'Update Attendance Records' : 'Save Attendance Records' }}
                        </button>
                    </div>
                </form>
            </div>
            
            <script>
                // Scroll to roster if a period slot is active
                document.addEventListener("DOMContentLoaded", function() {
                    const roster = document.getElementById("roster");
                    if (roster) {
                        roster.scrollIntoView({ behavior: "smooth", block: "start" });
                    }
                });
            </script>
        @endif
    @endif
@else
    <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
        <p class="text-gray-400 font-medium italic">Please select a class to record or view attendance.</p>
    </div>
@endif

@endsection
