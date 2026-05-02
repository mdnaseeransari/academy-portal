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
    
    <!-- My Students (Active) -->
    <a href="{{ route('teacher.students') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
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
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">My Students — {{ $class->name }}</h1>
        <p class="text-sm text-gray-500 font-medium">{{ $students->total() }} students enrolled</p>
    </div>
    <div class="flex items-center gap-3">
        <button disabled class="bg-gray-100 text-gray-400 px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Download PDF
        </button>
    </div>
</div>

<!-- Search Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('teacher.students') }}" method="GET" class="flex flex-wrap items-center gap-4">
        <div class="flex-grow min-w-[300px]">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or roll number"
                class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm">
        </div>
        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-[42px]">
            Search
        </button>
        @if($search)
            <a href="{{ route('teacher.students') }}" class="text-sm text-red-600 font-bold hover:underline">Clear Search</a>
        @endif
    </form>
</div>

<!-- Students Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Parent Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Parent Phone</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Attendance %</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                @php
                    $attendance = $student->attendance_percentage ?? 0;
                    $badgeClass = $attendance >= 75 ? 'bg-green-100 text-green-700' : ($attendance >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                    
                    $studentData = [
                        'name' => $student->user->name,
                        'roll_number' => $student->roll_number,
                        'parent_name' => $student->parent_name ?? 'N/A',
                        'phone' => $student->phone ?? 'N/A',
                        'address' => $student->address ?? 'N/A',
                        'attendance_records' => $student->attendances->take(5)->map(fn($a) => [
                            'date' => \Carbon\Carbon::parse($a->date)->format('d M'),
                            'status' => ucfirst($a->status)
                        ]),
                        'marks' => $student->marks->take(5)->map(fn($m) => [
                            'subject' => $m->subject,
                            'score' => $m->score . '/' . $m->total_marks
                        ]),
                        'remarks' => $student->remarks->take(3)->map(fn($r) => [
                            'date' => \Carbon\Carbon::parse($r->date)->format('d M Y'),
                            'text' => $r->remark_text
                        ])
                    ];
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-gray-800">{{ $student->roll_number }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-gray-800">{{ $student->user->name }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">{{ $student->parent_name ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-gray-600">{{ $student->phone ?? 'N/A' }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                            {{ $attendance }}%
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button type="button" 
                                onclick="openModal(this)" 
                                data-student='@json($studentData)'
                                class="bg-white text-[#2c3e80] border border-[#2c3e80] px-3 py-1.5 rounded-lg hover:bg-[#2c3e80] hover:text-white transition font-bold text-xs">
                            View Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                        No students found matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $students->links() }}
</div>

<!-- Tailwind Modal -->
<div id="studentModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <!-- Dark Overlay -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal()"></div>
    
    <!-- Modal Card -->
    <div class="relative min-h-screen flex items-start justify-center p-4">
        <div class="relative bg-white rounded-xl shadow-xl max-w-2xl w-full mx-auto mt-20 p-8 transform transition-all">
            <!-- Close Button -->
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Modal Content -->
            <div id="modalContent">
                <div class="mb-8">
                    <h2 id="modalName" class="text-2xl font-bold text-gray-800"></h2>
                    <p id="modalRoll" class="text-sm text-blue-600 font-bold uppercase tracking-wider mt-1"></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Parent Information</h4>
                        <p class="text-sm font-bold text-gray-700">Name: <span id="modalParent" class="font-medium text-gray-600"></span></p>
                        <p class="text-sm font-bold text-gray-700 mt-2">Phone: <span id="modalPhone" class="font-medium text-gray-600"></span></p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Address</h4>
                        <p id="modalAddress" class="text-sm text-gray-600 leading-relaxed"></p>
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Attendance -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                            Recent Attendance
                        </h4>
                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-500">
                                        <th class="px-4 py-2 font-bold uppercase">Date</th>
                                        <th class="px-4 py-2 font-bold uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAttendance" class="divide-y divide-gray-200"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Marks -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Recent Academic Marks
                        </h4>
                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-100">
                            <table class="w-full text-left text-xs">
                                <thead>
                                    <tr class="bg-gray-100 text-gray-500">
                                        <th class="px-4 py-2 font-bold uppercase">Subject</th>
                                        <th class="px-4 py-2 font-bold uppercase">Score</th>
                                    </tr>
                                </thead>
                                <tbody id="modalMarks" class="divide-y divide-gray-200"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Latest Remarks
                        </h4>
                        <div id="modalRemarks" class="space-y-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal(btn) {
    const data = JSON.parse(btn.dataset.student);
    
    // Basic Info
    document.getElementById('modalName').textContent = data.name;
    document.getElementById('modalRoll').textContent = 'Roll No: ' + data.roll_number;
    document.getElementById('modalParent').textContent = data.parent_name;
    document.getElementById('modalPhone').textContent = data.phone;
    document.getElementById('modalAddress').textContent = data.address;

    // Attendance
    const attBody = document.getElementById('modalAttendance');
    attBody.innerHTML = '';
    if(data.attendance_records.length > 0) {
        data.attendance_records.forEach(rec => {
            const statusBadge = rec.status === 'Present' ? 'text-green-600 font-bold' : 'text-red-600 font-bold';
            attBody.innerHTML += `
                <tr>
                    <td class="px-4 py-2 text-gray-600">${rec.date}</td>
                    <td class="px-4 py-2 ${statusBadge}">${rec.status}</td>
                </tr>
            `;
        });
    } else {
        attBody.innerHTML = '<tr><td colspan="2" class="px-4 py-4 text-center text-gray-400 italic">No attendance records found.</td></tr>';
    }

    // Marks
    const marksBody = document.getElementById('modalMarks');
    marksBody.innerHTML = '';
    if(data.marks.length > 0) {
        data.marks.forEach(m => {
            marksBody.innerHTML += `
                <tr>
                    <td class="px-4 py-2 text-gray-600">${m.subject}</td>
                    <td class="px-4 py-2 font-bold text-[#2c3e80]">${m.score}</td>
                </tr>
            `;
        });
    } else {
        marksBody.innerHTML = '<tr><td colspan="2" class="px-4 py-4 text-center text-gray-400 italic">No marks recorded.</td></tr>';
    }

    // Remarks
    const remarksDiv = document.getElementById('modalRemarks');
    remarksDiv.innerHTML = '';
    if(data.remarks.length > 0) {
        data.remarks.forEach(r => {
            remarksDiv.innerHTML += `
                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mb-1">${r.date}</p>
                    <p class="text-xs text-gray-600 italic leading-relaxed">"${r.text}"</p>
                </div>
            `;
        });
    } else {
        remarksDiv.innerHTML = '<p class="text-xs text-gray-400 italic">No remarks provided yet.</p>';
    }

    document.getElementById('studentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close on escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});
</script>
@endpush
@endsection
