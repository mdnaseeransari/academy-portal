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
    
    <!-- View Marks -->
    <a href="{{ route('student.marks') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        View Marks
    </a>
    
    <!-- Assignments (Active) -->
    <a href="{{ route('student.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
    <h1 class="text-2xl font-bold text-gray-800">My Assignments</h1>
    <p class="text-sm text-gray-500">Track and submit your class assignments.</p>
</div>

<!-- Tabs -->
<div class="flex gap-2 mb-8 bg-white p-2 rounded-xl border border-gray-100 shadow-sm inline-flex">
    @php
        $currentTab = request('tab', 'pending');
    @endphp
    <a href="?tab=pending" 
       class="px-6 py-2 text-sm font-bold rounded-lg transition {{ $currentTab == 'pending' ? 'bg-[#2c3e80] text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
        Pending
    </a>
    <a href="?tab=submitted" 
       class="px-6 py-2 text-sm font-bold rounded-lg transition {{ $currentTab == 'submitted' ? 'bg-[#2c3e80] text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
        Submitted
    </a>
</div>

<!-- Content Area -->
<div class="mt-4">
    @if($currentTab == 'pending')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($pending as $assignment)
                @php
                    $isOverdue = \Carbon\Carbon::parse($assignment->due_date)->isPast();
                    $isSubmitted = $assignment->submissions_count > 0; // Assuming this is passed or checked via relationship
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex flex-col gap-2 sm:flex-row sm:gap-4 sm:items-start mb-2 w-full">
                            <h3 class="flex-1 min-w-0 text-lg font-bold text-gray-800 break-words overflow-hidden">{{ $assignment->title }}</h3>
                            @if($isOverdue && !$isSubmitted)
                                <span class="flex-shrink-0 bg-red-100 text-red-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">Overdue</span>
                            @elseif($isSubmitted)
                                <span class="flex-shrink-0 bg-green-100 text-green-700 px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap">Submitted</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mb-4">Assigned by: <span class="font-semibold">{{ $assignment->teacher->name }}</span></p>
                        
                        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                            {{ Str::limit($assignment->description, 100) }}
                        </p>

                        <div class="flex items-center gap-2 mb-6">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                            <span class="text-xs font-medium {{ $isOverdue && !$isSubmitted ? 'text-red-600' : 'text-gray-500' }}">
                                Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @if($assignment->file_path)
                            <a href="{{ $assignment->file_url }}" download class="inline-flex items-center gap-2 bg-white text-gray-700 border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 text-xs transition font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download Resources
                            </a>
                        @endif

                        @if(!$isSubmitted)
                            @if(!$isOverdue)
                                <form action="{{ route('student.assignments.upload') }}" method="POST" enctype="multipart/form-data" class="pt-4 border-t border-gray-50">
                                    @csrf
                                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                    <div class="mb-3">
                                        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Upload Submission (.pdf, .doc)</label>
                                        <input type="file" name="file" accept=".pdf,.doc,.docx" required 
                                            class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 border border-gray-200 rounded-lg">
                                    </div>
                                    <button type="submit" class="w-full bg-[#2c3e80] text-white px-4 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm">
                                        Submit Assignment
                                    </button>
                                </form>
                            @else
                                <div class="pt-4 border-t border-gray-50 text-center">
                                    <p class="text-sm text-red-500 font-bold italic">Deadline Passed - Submission Closed</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-xl border border-gray-100">
                    <p class="text-gray-400 font-medium italic">No pending assignments.</p>
                </div>
            @endforelse
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @if($submitted->isEmpty())
                <div class="p-20 text-center">
                    <p class="text-gray-400 font-medium italic">No submitted assignments yet.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Assignment Title</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted On</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($submitted as $submission)
                            @php
                                $statusBadge = match($submission->status) {
                                    'submitted' => 'bg-blue-100 text-blue-700',
                                    'late' => 'bg-yellow-100 text-yellow-700',
                                    'graded' => 'bg-purple-100 text-purple-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800 break-words overflow-hidden">{{ $submission->assignment->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->submitted_at)->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusBadge }}">
                                        {{ $submission->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-[#2c3e80]">
                                    {{ $submission->grade ?? '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
