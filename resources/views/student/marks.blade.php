@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- View Attendance -->
    <a href="{{ route('student.attendance') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
        View Attendance
    </a>
    
    <!-- View Marks (Active) -->
    <a href="{{ route('student.marks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        View Marks
    </a>
    
    <!-- Assignments -->
    <a href="{{ route('student.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.247 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
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
    <h1 class="text-2xl font-bold text-gray-800">My Exam Marks</h1>
    <p class="text-sm text-gray-500">View your performance across different subjects and exams.</p>
</div>

<!-- Filter Tabs -->
<div class="flex flex-wrap gap-2 mb-8 bg-white p-2 rounded-xl border border-gray-100 shadow-sm inline-flex">
    @php
        $tabs = [
            '' => 'All',
            'unit_test' => 'Unit Test',
            'half_yearly' => 'Half Yearly',
            'final' => 'Final',
            'other' => 'Other'
        ];
    @endphp

    @foreach($tabs as $key => $label)
        <a href="?exam_type={{ $key }}" 
           class="px-5 py-2 text-sm font-bold rounded-lg transition {{ $exam_type == $key ? 'bg-[#2c3e80] text-white' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-100' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

<!-- Marks Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    @if($marks->isEmpty())
        <div class="p-20 text-center">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <p class="text-gray-400 font-medium italic">No marks found for this filter.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Exam Type</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Marks</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Percentage</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Grade</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($marks as $mark)
                        @php
                            $percentage = ($mark->marks_obtained / $mark->total_marks) * 100;
                            
                            if ($percentage >= 90) {
                                $grade = 'A+';
                                $gradeClass = 'bg-green-200 text-green-900';
                            } elseif ($percentage >= 75) {
                                $grade = 'A';
                                $gradeClass = 'bg-green-100 text-green-800';
                            } elseif ($percentage >= 60) {
                                $grade = 'B';
                                $gradeClass = 'bg-blue-100 text-blue-800';
                            } elseif ($percentage >= 45) {
                                $grade = 'C';
                                $gradeClass = 'bg-yellow-100 text-yellow-800';
                            } else {
                                $grade = 'F';
                                $gradeClass = 'bg-red-100 text-red-800';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800">{{ $mark->subject }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $mark->exam_type) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                {{ $mark->marks_obtained }} / {{ $mark->total_marks }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-gray-800">{{ number_format($percentage, 1) }}%</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $gradeClass }}">
                                    {{ $grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $mark->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Subject-wise Averages -->
<div class="mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Subject-wise Performance</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $groupedMarks = $marks->groupBy('subject');
        @endphp

        @foreach($groupedMarks as $subject => $subjectMarks)
            @php
                $avgPercentage = $subjectMarks->avg(fn($m) => ($m->marks_obtained / $m->total_marks) * 100);
                $barColor = $avgPercentage >= 75 ? 'bg-green-500' : ($avgPercentage >= 50 ? 'bg-yellow-500' : 'bg-red-500');
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wide">{{ $subject }}</h4>
                    <span class="text-lg font-bold text-gray-800">{{ number_format($avgPercentage, 1) }}%</span>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="{{ $barColor }} h-2 rounded-full" style="width: {{ min($avgPercentage, 100) }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Average based on {{ $subjectMarks->count() }} exams</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
