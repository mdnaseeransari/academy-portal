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

    <!-- Assignments (Active) -->
    <a href="{{ route('teacher.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium transition">
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
    <h1 class="text-2xl font-bold text-gray-800">Assignments Management</h1>
    <p class="text-sm text-gray-500">Create new assignments for your students and track their submissions.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <!-- LEFT COLUMN — Create Assignment Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Create New Assignment</h3>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-4 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('teacher.assignments.create') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <!-- Select Class -->
                <div>
                    <label for="class_id" class="block text-sm font-bold text-gray-700 mb-2">Select Class*</label>
                    <select name="class_id" id="class_id" required 
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('class_id') border-red-500 @enderror">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title*</label>
                    <input type="text" name="title" id="title" required 
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('title') border-red-500 @enderror"
                        placeholder="e.g. Mathematics Chapter 5 Quiz" value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" 
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('description') border-red-500 @enderror"
                        placeholder="Provide details about the assignment...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-bold text-gray-700 mb-2">Due Date*</label>
                    <input type="date" id="due_date" name="due_date" required value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}"
                        class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attach File -->
                <div>
                    <label for="file" class="block text-sm font-bold text-gray-700 mb-2">Attach File (optional)</label>
                    <div class="relative">
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-[#2c3e80] hover:file:bg-gray-100 cursor-pointer border border-gray-300 rounded-lg @error('file') border-red-500 @enderror">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">Accepted formats: PDF, DOC, DOCX (Max 5MB)</p>
                    @error('file')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[#2c3e80] text-white px-6 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-md">
                    Create Assignment
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT COLUMN — Existing Assignments List -->
    <div class="lg:col-span-3">
        <h3 class="text-lg font-bold text-gray-800 mb-4">My Assignments</h3>
        
        <div class="space-y-4">
            @forelse($assignments as $assignment)
                @php
                    $isOverdue = $assignment->due_date && \Carbon\Carbon::parse($assignment->due_date)->isPast();
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-800 leading-tight mb-1">{{ $assignment->title }}</h4>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                                <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded font-bold uppercase tracking-wider">
                                    {{ $assignment->academicClass->name ?? 'N/A' }}
                                </span>
                                <span class="text-xs {{ $isOverdue ? 'text-red-600 font-bold' : 'text-gray-400 font-medium' }}">
                                    Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, Y') }}
                                </span>
                                <span class="text-xs text-gray-300">|</span>
                                <span class="text-xs text-gray-500">
                                    Assigned by: <span class="font-bold text-[#2c3e80]">{{ $assignment->creator->name ?? 'Admin' }}</span>
                                </span>
                                @if($isOverdue)
                                    <span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Overdue</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-blue-50 text-[#2c3e80] text-xs px-3 py-1.5 rounded-lg font-bold border border-blue-100">
                                {{ $assignment->submissions_count ?? 0 }} submissions
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ Str::limit($assignment->description, 80) }}
                        </p>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                        <div class="flex items-center gap-4">
                            @if($assignment->file_path)
                                <a href="{{ $assignment->file_url }}" target="_blank" class="flex items-center gap-2 text-[#2c3e80] hover:text-[#1e2d5e] text-xs font-bold transition underline decoration-2 underline-offset-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download File
                                </a>
                            @endif
                            <a href="{{ route('teacher.submissions', $assignment->id) }}" class="flex items-center gap-2 bg-[#2c3e80] text-white px-4 py-2 rounded-lg hover:bg-[#1e2d5e] text-xs font-bold transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View Submissions
                            </a>
                        </div>
                        
                        <form method="POST"
                              action="{{ route('teacher.assignments.delete', $assignment->id) }}"
                              onsubmit="return confirm('Delete this assignment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-xs font-bold transition shadow-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-100 p-12 text-center shadow-sm">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <p class="text-gray-400 font-medium italic">No assignments created yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
