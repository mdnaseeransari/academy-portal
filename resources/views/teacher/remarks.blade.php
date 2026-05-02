@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
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
    
    <!-- Add Remark (Active) -->
    <a href="{{ route('teacher.remarks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
        Add Remark
    </a>
    
    <!-- My Students -->
    <a href="{{ route('teacher.students') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        My Students
    </a>
    
    <!-- Timetable -->
    <a href="{{ route('teacher.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Timetable
    </a>
@endpush

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Student Remarks</h1>
    <p class="text-sm text-gray-500">Add constructive feedback and track performance notes for your students.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <!-- LEFT COLUMN — Add Remark Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Add Remark</h3>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('teacher.remarks.add') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Student Dropdown -->
                <div>
                    <label for="student_id" class="block text-sm font-bold text-gray-700 mb-2">Select Student</label>
                    <select name="student_id" id="student_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('student_id') border-red-500 @enderror">
                        <option value="">-- Select Student --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->roll_number }} — {{ $student->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remark Textarea -->
                <div>
                    <label for="remark_text" class="block text-sm font-bold text-gray-700 mb-2">Remark</label>
                    <textarea name="remark_text" id="remark_text" rows="4" required minlength="10" 
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('remark_text') border-red-500 @enderror"
                        placeholder="Enter student performance remark...">{{ old('remark_text') }}</textarea>
                    @error('remark_text')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Picker -->
                <div>
                    <label for="date" class="block text-sm font-bold text-gray-700 mb-2">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('date') border-red-500 @enderror">
                    @error('date')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-md">
                    Add Remark
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT COLUMN — Recent Remarks List -->
    <div class="lg:col-span-3">
        <h3 class="text-lg font-bold text-gray-800 mb-4">My Recent Remarks</h3>
        
        <div class="space-y-4">
            @forelse($recent_remarks as $remark)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $remark->student->user->name }}</p>
                            <p class="text-xs text-gray-400 font-medium">Roll No: {{ $remark->student->roll_number }}</p>
                        </div>
                        <div class="text-right sm:text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">
                                {{ \Carbon\Carbon::parse($remark->date)->format('d Jan Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 leading-relaxed italic">
                            "{{ $remark->remark_text }}"
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <form method="POST"
                            action="{{ route('teacher.remarks.delete', $remark->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this remark?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-3 py-1.5 rounded-lg hover:bg-red-700 text-xs font-bold transition shadow-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                    </div>
                    <p class="text-gray-400 font-medium italic">No remarks added yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
