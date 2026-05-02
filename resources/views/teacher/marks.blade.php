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
    
    <!-- Upload Marks (Active) -->
    <a href="{{ route('teacher.marks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
    
    <!-- Timetable -->
    <a href="{{ route('teacher.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Timetable
    </a>
@endpush

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Upload Examination Marks</h1>
    <p class="text-sm text-gray-500">Select class and exam type to enter student results.</p>
</div>

<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('teacher.marks') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                <option value="">-- Choose Class --</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Exam Type</label>
            <select name="exam_type" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
                <option value="Unit Test" {{ $exam_type == 'Unit Test' ? 'selected' : '' }}>Unit Test</option>
                <option value="Half Yearly" {{ $exam_type == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                <option value="Final" {{ $exam_type == 'Final' ? 'selected' : '' }}>Final</option>
                <option value="Other" {{ $exam_type == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
            <input type="text" value="{{ $teacher->subject }}" readonly class="w-full bg-gray-50 border-gray-300 rounded-lg text-gray-500 cursor-not-allowed text-sm">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Total Marks</label>
            <input type="number" name="total_marks" value="{{ $total_marks ?? 100 }}" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Exam Date</label>
            <input type="date" name="exam_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
        </div>

        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm">
            Load Students
        </button>
    </form>
</div>

@if($students)
    <!-- Marks Entry Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800">Student List</h3>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">Entering marks for {{ count($students) }} students</p>
        </div>

        @if(session('success'))
            <div class="mx-6 mt-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 flex items-center gap-3">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('teacher.marks.upload') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $selected_class }}">
            <input type="hidden" name="exam_type" value="{{ $exam_type }}">
            <input type="hidden" name="subject" value="{{ $teacher->subject }}">
            <input type="hidden" name="total_marks" value="{{ $total_marks }}">
            <input type="hidden" name="exam_date" value="{{ request('exam_date') }}">

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marks Obtained</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Absent</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Remarks</th>
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
                                <div class="flex items-center gap-2">
                                    <input type="number" 
                                           name="marks[{{ $student->id }}][marks_obtained]" 
                                           min="0" max="{{ $total_marks }}"
                                           class="w-20 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-[#2c3e80] focus:border-[#2c3e80] transition"
                                           placeholder="0">
                                    <span class="text-xs text-gray-400 font-bold">/ {{ $total_marks }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <input type="checkbox" 
                                       name="marks[{{ $student->id }}][absent]" 
                                       id="absent_{{ $student->id }}"
                                       class="w-5 h-5 rounded border-gray-300 text-[#2c3e80] focus:ring-[#2c3e80] transition accent-[#2c3e80]"
                                       onchange="toggleMarks({{ $student->id }})">
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" 
                                       name="marks[{{ $student->id }}][remarks]" 
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
                    Save Marks
                </button>
            </div>
        </form>
    </div>
@else
    <!-- Empty State for Loading -->
    <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm mb-8">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <p class="text-gray-400 font-medium italic">Select a class and exam type above to load students.</p>
    </div>
@endif

<!-- Previously Uploaded Marks Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Previously Uploaded Marks</h3>
        <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">History for {{ $teacher->subject }}</p>
    </div>

    @if($previous_marks->isEmpty())
        <div class="p-12 text-center">
            <p class="text-gray-400 font-medium italic">No marks uploaded yet for this selection.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marks</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Percentage</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($previous_marks as $mark)
                    @php
                        $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                        $badgeColor = match(true) {
                            $percentage >= 75 => 'bg-green-100 text-green-700',
                            $percentage >= 50 => 'bg-yellow-100 text-yellow-700',
                            default => 'bg-red-100 text-red-700'
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">{{ $mark->student->user->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800">{{ $mark->marks_obtained }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $mark->total_marks }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeColor }}">
                                {{ number_format($percentage, 1) }}%
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-400 italic">{{ \Carbon\Carbon::parse($mark->exam_date)->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button disabled class="opacity-50 cursor-not-allowed bg-white text-gray-700 border border-gray-300 px-3 py-1 rounded-lg text-xs font-bold">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleMarks(studentId) {
    const checkbox = document.getElementById('absent_' + studentId);
    const marksInput = document.querySelector('input[name="marks[' + studentId + '][marks_obtained]"]');
    if (checkbox.checked) {
        marksInput.value = 0;
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
