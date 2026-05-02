@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
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
    
    <!-- Reports (Active) -->
    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
<div class="mb-8 no-print">
    <h1 class="text-2xl font-bold text-gray-800">Academic Reports</h1>
    <p class="text-sm text-gray-500 font-medium">Generate and view detailed analytical reports.</p>
</div>

<!-- Tabs Navigation -->
<div class="flex flex-wrap gap-2 mb-8 no-print">
    <a href="{{ route('admin.reports', ['tab' => 'attendance']) }}" 
       class="px-6 py-2.5 rounded-lg text-sm font-bold transition {{ $tab == 'attendance' ? 'bg-[#2c3e80] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-100 hover:bg-gray-50' }}">
        Attendance Report
    </a>
    <a href="{{ route('admin.reports', ['tab' => 'marks']) }}" 
       class="px-6 py-2.5 rounded-lg text-sm font-bold transition {{ $tab == 'marks' ? 'bg-[#2c3e80] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-100 hover:bg-gray-50' }}">
        Marks Analytics
    </a>
    <a href="{{ route('admin.reports', ['tab' => 'student']) }}" 
       class="px-6 py-2.5 rounded-lg text-sm font-bold transition {{ $tab == 'student' ? 'bg-[#2c3e80] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-100 hover:bg-gray-50' }}">
        Student Profile Report
    </a>
</div>

<!-- Tab Content -->
@if($tab == 'attendance')
    <!-- Attendance Report Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 no-print">
        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="hidden" name="tab" value="attendance">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Class</label>
                <select name="class_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Month</label>
                <select name="month" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (request('month') ?? date('n')) == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Year</label>
                <select name="year" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    @foreach(range(date('Y')-2, date('Y')) as $y)
                        <option value="{{ $y }}" {{ (request('year') ?? date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    @if(count($attendance_report) > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Student Name</th>
                        <th class="px-6 py-4">Roll No</th>
                        <th class="px-6 py-4">Total Days</th>
                        <th class="px-6 py-4">Present</th>
                        <th class="px-6 py-4">Absent</th>
                        <th class="px-6 py-4">Late</th>
                        <th class="px-6 py-4 text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($attendance_report as $data)
                    @php
                        $perc = $data['percentage'];
                        $color = $perc >= 75 ? 'bg-green-100 text-green-700' : ($perc >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $data['name'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-[#2c3e80]">{{ $data['roll_no'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $data['total_days'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">{{ $data['present'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-red-600">{{ $data['absent'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-yellow-600">{{ $data['late'] }}</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $color }}">
                                {{ $perc }}%
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white py-20 rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
        <p class="text-gray-400 italic">Select filters above to generate report.</p>
    </div>
    @endif

@elseif($tab == 'marks')
    <!-- Marks Report Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 no-print">
        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="hidden" name="tab" value="marks">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Class</label>
                <select name="class_id" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Exam Type</label>
                <select name="exam_type" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    <option value="">All Exams</option>
                    <option value="unit_test" {{ request('exam_type') == 'unit_test' ? 'selected' : '' }}>Unit Test</option>
                    <option value="half_yearly" {{ request('exam_type') == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>
                    <option value="final" {{ request('exam_type') == 'final' ? 'selected' : '' }}>Final</option>
                    <option value="other" {{ request('exam_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    @if(count($marks_report) > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Roll No</th>
                        <th class="px-6 py-4">Student Name</th>
                        <th class="px-6 py-4">Marks Obtained</th>
                        <th class="px-6 py-4">Total Marks</th>
                        <th class="px-6 py-4 text-center">Percentage</th>
                        <th class="px-6 py-4 text-right">Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $sum_perc = 0; @endphp
                    @foreach($marks_report as $data)
                    @php
                        $sum_perc += $data['percentage'];
                        $grade = $data['grade'];
                        $gradeColor = match($grade) {
                            'A+' => 'bg-green-700 text-white',
                            'A' => 'bg-green-500 text-white',
                            'B' => 'bg-blue-500 text-white',
                            'C' => 'bg-yellow-500 text-white',
                            default => 'bg-red-500 text-white'
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-[#2c3e80]">{{ $data['roll_no'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $data['name'] }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-700">{{ $data['marks'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $data['total'] }}</td>
                        <td class="px-6 py-4 text-center text-sm font-bold">{{ $data['percentage'] }}%</td>
                        <td class="px-6 py-4 text-right">
                            <span class="px-3 py-1 rounded-md text-[10px] font-bold {{ $gradeColor }}">
                                {{ $grade }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-[#f8fafc]">
                    <tr class="font-bold">
                        <td colspan="4" class="px-6 py-4 text-sm text-gray-500 uppercase tracking-widest">Class Average</td>
                        <td class="px-6 py-4 text-center text-lg text-[#2c3e80]">{{ number_format($sum_perc / count($marks_report), 1) }}%</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white py-20 rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
        <p class="text-gray-400 italic">Select filters above to generate marks report.</p>
    </div>
    @endif

@elseif($tab == 'student')
    <!-- Student Report Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8 no-print">
        <form method="GET" action="{{ route('admin.reports') }}" class="flex gap-4">
            <input type="hidden" name="tab" value="student">
            <div class="flex-grow">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Student Search</label>
                <input type="text" name="student_search" value="{{ request('student_search') }}" placeholder="Enter Student Name or Roll Number" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-[#2c3e80] text-white px-8 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Search Profile
                </button>
            </div>
        </form>
    </div>

    @if($selected_student)
    <div id="student-report-card">
        <div class="flex items-center justify-between mb-8 no-print">
            <h3 class="text-xl font-bold text-gray-800">Generated Report Card</h3>
            <button onclick="window.print()" class="bg-white text-gray-700 border border-gray-300 px-6 py-2 rounded-lg text-sm font-bold hover:bg-gray-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print Report Card
            </button>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
            <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
                <div class="w-32 h-32 bg-[#2c3e80] text-white rounded-full flex items-center justify-center text-4xl font-bold">
                    {{ substr($selected_student->user->name, 0, 1) }}
                </div>
                <div class="flex-grow grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Student Name</p>
                        <p class="text-lg font-bold text-gray-800">{{ $selected_student->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Roll Number</p>
                        <p class="text-lg font-bold text-[#2c3e80]">{{ $selected_student->roll_number }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Class</p>
                        <p class="text-lg font-bold text-gray-800">{{ $selected_student->academicClass->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Admission Date</p>
                        <p class="text-sm font-bold text-gray-600">{{ \Carbon\Carbon::parse($selected_student->admission_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Parent Name</p>
                        <p class="text-sm font-bold text-gray-600">{{ $selected_student->parent_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contact</p>
                        <p class="text-sm font-bold text-gray-600">{{ $selected_student->parent_phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Attendance Progress -->
            <div class="mt-10 pt-10 border-t border-gray-50">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-gray-800">Academic Attendance Overview</h4>
                    <span class="text-lg font-bold text-[#2c3e80]">{{ $selected_student->attendance_percentage ?? 0 }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                    <div class="bg-[#2c3e80] h-full rounded-full transition-all duration-1000" style="width: {{ $selected_student->attendance_percentage ?? 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Performance Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h4 class="font-bold text-gray-800">Recent Exam Results</h4>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-3">Subject</th>
                            <th class="px-6 py-3">Exam</th>
                            <th class="px-6 py-3 text-right">Marks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($selected_student->marks as $mark)
                        <tr class="text-sm">
                            <td class="px-6 py-4 font-bold text-gray-700">{{ $mark->subject }}</td>
                            <td class="px-6 py-4 text-gray-500 capitalize">{{ str_replace('_', ' ', $mark->exam_type) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-[#2c3e80]">{{ $mark->marks_obtained }}/{{ $mark->total_marks }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">No mark records found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Remarks -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h4 class="font-bold text-gray-800 mb-6 border-b pb-4">Teacher Observations</h4>
                <div class="space-y-6">
                    @forelse($selected_student->remarks as $remark)
                    <div class="relative pl-6 border-l-2 border-[#2c3e80]/20">
                        <div class="absolute -left-[5px] top-0 w-2 h-2 rounded-full bg-[#2c3e80]"></div>
                        <p class="text-sm text-gray-600 italic">"{{ $remark->remark_text }}"</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase mt-2">— {{ $remark->teacher->name }}, {{ \Carbon\Carbon::parse($remark->created_at)->format('d M Y') }}</p>
                    </div>
                    @empty
                    <p class="text-center text-gray-400 italic py-8">No specific remarks recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white py-20 rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
        <p class="text-gray-400 italic">Search for a student by name or roll number to view profile report.</p>
    </div>
    @endif

@endif

@push('scripts')
<style>
@media print {
    #sidebar, header, .no-print, footer { display: none !important; }
    main { padding: 0 !important; margin: 0 !important; }
    .lg\:ml-64 { margin-left: 0 !important; }
    #student-report-card { border: none !important; box-shadow: none !important; }
    body { background: white !important; }
}
</style>
@endpush
@endsection
