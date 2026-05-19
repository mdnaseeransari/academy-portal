@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manage Examination Marks</h1>
        <p class="text-sm text-gray-500">Upload or update student marks for any class and subject.</p>
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

<!-- Schedule a Test Section -->
<div class="bg-indigo-50 rounded-xl shadow-sm border border-[#2c3e80] p-6 mb-8 relative overflow-hidden">
    <!-- Decorative background element -->
    <div class="absolute -right-10 -top-10 text-indigo-100 opacity-50">
        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 002 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z"/></svg>
    </div>
    
    <div class="relative z-10">
        <div class="mb-4">
            <h3 class="text-xl font-bold text-[#2c3e80] flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Schedule an Upcoming Exam
            </h3>
            <p class="text-sm text-indigo-800">Fill this out to immediately notify students on their dashboard about an upcoming test.</p>
        </div>

        <form action="{{ route('admin.exams.schedule') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
            @csrf
            
            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Class</label>
                <select name="class_id" required class="w-full border-indigo-200 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm bg-white shadow-sm">
                    <option value="">-- Choose Class --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Exam Type</label>
                <select name="exam_type" class="w-full border-indigo-200 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm bg-white shadow-sm">
                    <option value="Weekly Assessment">Weekly Assessment</option>
                    <option value="Mock Test">Mock Test</option>
                </select>
            </div>

            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Subject</label>
                <input type="text" name="subject" required placeholder="Enter Subject Name" class="w-full border border-indigo-200 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] bg-white shadow-sm">
            </div>
            
            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Topic</label>
                <input type="text" name="topic" required placeholder="Exam Topic" class="w-full border border-indigo-200 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] bg-white shadow-sm">
            </div>
            
            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Date</label>
                <input type="date" name="scheduled_date" required min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" class="w-full border border-indigo-200 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] bg-white shadow-sm">
            </div>

            <div class="lg:col-span-1">
                <label class="block text-sm font-bold text-[#2c3e80] mb-2">Total Marks</label>
                <input type="number" name="total_marks" min="1" value="100" required class="w-full border border-indigo-200 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] bg-white shadow-sm">
            </div>

            <div class="lg:col-span-6 mt-2">
                <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Schedule & Notify Students
                </button>
            </div>
        </form>
    </div>
</div>

@if(isset($scheduled_exams) && $scheduled_exams->isNotEmpty())
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Scheduled Upcoming Tests
    </h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Class</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Subject & Topic</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Exam Type</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Total Marks</th>
                    <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($scheduled_exams as $exam)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3">
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold">{{ $exam->academicClass->name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-bold text-gray-800">{{ $exam->subject }}</div>
                        <div class="text-xs text-gray-500">{{ $exam->topic }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="bg-indigo-100 text-[#2c3e80] px-2 py-1 rounded text-xs font-bold uppercase">{{ $exam->exam_type }}</span>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                        {{ $exam->scheduled_date->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $exam->total_marks }}</td>
                    <td class="px-4 py-3 text-right">
                        <form action="{{ route('admin.exams.schedule.delete', $exam->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this scheduled exam? This will remove the notification for students.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg text-sm font-medium transition flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Shared Class Filter & Options -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Enter Marks for an Exam</h3>
    <form action="{{ route('admin.marks') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" onchange="window.location.href = '{{ route('admin.marks') }}?class_id=' + this.value" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                <option value="">-- Choose Class --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Exam Type</label>
            <select name="exam_type" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                <option value="Weekly Assessment" {{ $exam_type == 'Weekly Assessment' || $exam_type == 'WEEKLY_ASSESSMENT' ? 'selected' : '' }}>Weekly Assessment</option>
                <option value="Mock Test" {{ $exam_type == 'Mock Test' || $exam_type == 'MOCK_TEST' ? 'selected' : '' }}>Mock Test</option>
            </select>
        </div>

        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
            <input type="text" name="subject" value="{{ $subject }}" required placeholder="Enter Subject Name" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
        </div>
        
        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Topic</label>
            <input type="text" name="topic" value="{{ $topic }}" required placeholder="Exam Topic" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
        </div>
        
        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Date</label>
            <input type="date" name="date" value="{{ $exam_date }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
        </div>

        <div class="lg:col-span-1">
            <label class="block text-sm font-bold text-gray-700 mb-2">Total Marks</label>
            <input type="number" name="total_marks" value="{{ $total_marks }}" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
        </div>

        <div class="lg:col-span-1 sm:col-span-2 lg:col-span-6 mt-2">
            <button type="submit" class="w-full bg-[#2c3e80] text-white px-4 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-sm h-[42px]">
                Load Students
            </button>
        </div>
    </form>
</div>

@if($selected_class_id && $subject)
    @if($students->isEmpty())
        <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
            <p class="text-gray-400 font-medium italic">No students found in this class.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Marks Entry Form</h3>
                    <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">
                        Subject: <span class="font-bold text-gray-800">{{ $subject }}</span> | 
                        Exam: <span class="font-bold text-gray-800">{{ $exam_type }}</span> | 
                        Topic: <span class="font-bold text-gray-800">{{ $topic }}</span> | 
                        Date: <span class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($exam_date)->format('M d, Y') }}</span>
                    </p>
                </div>
                @if($previous_marks->isNotEmpty())
                    <span class="bg-blue-100 text-blue-800 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                        {{ $previous_marks->count() }} Existing Records
                    </span>
                @endif
            </div>

            <form action="{{ route('admin.saveMarks') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                <input type="hidden" name="exam_type" value="{{ $exam_type }}">
                <input type="hidden" name="subject" value="{{ $subject }}">
                <input type="hidden" name="topic" value="{{ $topic }}">
                <input type="hidden" name="date" value="{{ $exam_date }}">
                <input type="hidden" name="total_marks" value="{{ $total_marks }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marks Obtained</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Absent</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Remarks (Optional)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                                @php
                                    $prevMark = $previous_marks[$student->id] ?? null;
                                    $isAbsent = $prevMark && $prevMark->marks_obtained == 0 && $prevMark->total_marks > 0 ? true : false;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $student->roll_number }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $student->user->name }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <input type="number" 
                                                name="marks[{{ $student->id }}][marks_obtained]" 
                                                min="0" max="{{ $total_marks }}" step="0.01"
                                                value="{{ $prevMark ? $prevMark->marks_obtained : '' }}"
                                                class="w-24 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#2c3e80] focus:border-[#2c3e80] transition {{ $isAbsent ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                {{ $isAbsent ? 'disabled' : '' }}
                                                placeholder="0">
                                            <span class="text-xs text-gray-400 font-bold">/ {{ $total_marks }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="checkbox" 
                                            name="marks[{{ $student->id }}][absent]" 
                                            id="absent_{{ $student->id }}"
                                            {{ $isAbsent ? 'checked' : '' }}
                                            class="w-5 h-5 rounded border-gray-300 text-[#2c3e80] focus:ring-[#2c3e80] transition accent-[#2c3e80] cursor-pointer"
                                            onchange="toggleMarks({{ $student->id }})">
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" 
                                            name="marks[{{ $student->id }}][remarks]" 
                                            value="{{ $prevMark ? $prevMark->remarks : '' }}"
                                            placeholder="Feedback..."
                                            class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#2c3e80] focus:border-[#2c3e80] transition">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 text-right">
                    <button type="submit" class="bg-[#2c3e80] text-white px-10 py-3 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-md">
                        Save All Marks
                    </button>
                </div>
            </form>
        </div>
    @endif
@endif
<!-- All Recorded Exams History -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h3 class="text-lg font-bold text-gray-800">Uploaded Exams History</h3>
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Filter History by Class:</span>
            <select onchange="window.location.href = '{{ route('admin.marks') }}?class_id=' + this.value" class="border border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-xs font-bold text-gray-700 bg-white py-1 pr-8 pl-3 shadow-sm cursor-pointer">
                <option value="">-- All Classes --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    @if(isset($uploaded_exams) && $uploaded_exams->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Subject - Topic</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Class</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Exam Type</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($uploaded_exams as $exam)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-800">{{ $exam->subject }} - {{ $exam->topic }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($exam->class_name))
                                    <span class="inline-block text-[10px] font-bold text-emerald-800 bg-emerald-50 border border-emerald-100 px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $exam->class_name }}</span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block text-[10px] font-bold text-[#2c3e80] bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $exam->exam_type }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-gray-600 font-medium inline-flex items-center gap-1.5 whitespace-nowrap">
                                    <svg width="14" height="14" class="text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($exam->date)->format('M d, Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-gray-700">{{ $exam->total_marks }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.marks', ['class_id' => $exam->class_id, 'exam_type' => $exam->exam_type, 'subject' => $exam->subject, 'topic' => $exam->topic, 'date' => $exam->date, 'total_marks' => $exam->total_marks]) }}" 
                                   class="inline-block px-5 py-2 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#2c3e80] hover:border-[#2c3e80] transition shadow-sm whitespace-nowrap">
                                    View / Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="p-12 text-center bg-white">
            <p class="text-gray-400 font-medium italic">No exams recorded yet.</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleMarks(studentId) {
    const checkbox = document.getElementById('absent_' + studentId);
    const marksInput = document.querySelector('input[name="marks[' + studentId + '][marks_obtained]"]');
    if (checkbox.checked) {
        marksInput.value = '';
        marksInput.disabled = true;
        marksInput.classList.add('bg-gray-100', 'cursor-not-allowed');
    } else {
        marksInput.disabled = false;
        marksInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
    }
}
</script>
@endpush

@endsection
