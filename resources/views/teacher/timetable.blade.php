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
    
    <!-- Assignments -->
    <a href="{{ route('teacher.assignments') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('teacher.assignments*') ? 'text-white bg-white/20 font-medium' : 'text-white/80 hover:text-white hover:bg-white/10' }} rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
        Assignments
    </a>
    
    <!-- Timetable (Active) -->
    <a href="{{ route('teacher.timetable') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Timetable
    </a>
@endpush

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Teaching Schedule</h1>
        <p class="text-sm text-gray-500 font-medium">{{ $timetable->flatten()->count() }} classes this week</p>
    </div>
    <div class="no-print">
        <button onclick="window.print()" class="bg-white text-gray-700 border border-gray-300 px-6 py-2.5 rounded-lg hover:bg-gray-50 transition font-bold text-sm flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Timetable
        </button>
    </div>
</div>

@if($timetable->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest border-r border-gray-100 min-w-[150px]">Time Slot</th>
                        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <th class="day-header px-6 py-4 text-sm font-bold text-gray-600 border-r border-gray-100 text-center min-w-[160px]" data-day="{{ $day }}">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $time_slots = $timetable->flatten()->sortBy('time_start')->unique(function ($item) {
                            return $item->time_start . $item->time_end;
                        });
                        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                    @endphp

                    @foreach($time_slots as $slot)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-6 border-r border-gray-100 bg-gray-50/30">
                            <div class="flex items-center gap-3">
                                <div class="w-1.5 h-10 bg-[#2c3e80] rounded-full"></div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($slot->time_start)->format('h:i A') }}
                                    </p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">to</p>
                                    <p class="text-sm font-bold text-gray-800">
                                        {{ \Carbon\Carbon::parse($slot->time_end)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        @foreach($days as $day)
                            <td class="px-4 py-6 border-r border-gray-100 text-center">
                                @php
                                    $entry = $timetable->get($day)?->first(function($item) use ($slot) {
                                        return $item->time_start == $slot->time_start && $item->time_end == $slot->time_end;
                                    });
                                @endphp

                                @if($entry)
                                    <div class="bg-blue-50/50 rounded-lg p-3 border border-blue-100/50">
                                        <p class="text-sm font-bold text-[#2c3e80] leading-tight mb-1">
                                            {{ $entry->academicClass->name ?? 'Class' }}
                                        </p>
                                        <p class="text-[11px] font-medium text-blue-600/70">
                                            {{ $entry->subject }}
                                        </p>
                                    </div>
                                @else
                                    <span class="text-gray-300 font-bold">-</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="py-24 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-800">No schedule found</h3>
        <p class="text-gray-400 font-medium italic mt-1">Please contact the administrator to assign your classes.</p>
    </div>
@endif

@push('scripts')
<style>
@media print {
    #sidebar, #navbar, .no-print, .sidebar-links { display: none !important; }
    .content-area { margin: 0 !important; width: 100% !important; padding: 0 !important; }
    body { background: white !important; }
    .bg-white { border: none !important; shadow: none !important; }
    .day-header.bg-blue-50 { background-color: #f0f7ff !important; -webkit-print-color-adjust: exact; }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const today = days[new Date().getDay()];
        
        document.querySelectorAll('.day-header').forEach(th => {
            if (th.dataset.day === today) {
                th.classList.remove('text-gray-600');
                th.classList.add('bg-blue-50', 'text-[#2c3e80]', 'ring-2', 'ring-blue-100', 'rounded-t-lg');
                
                // Highlight the entire column cells slightly
                const index = Array.from(th.parentNode.children).indexOf(th);
                document.querySelectorAll('tbody tr').forEach(tr => {
                    const td = tr.children[index];
                    if (td) td.classList.add('bg-blue-50/10');
                });
            }
        });
    });
</script>
@endpush
@endsection
