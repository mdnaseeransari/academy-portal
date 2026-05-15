@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-sm text-gray-500 font-medium">System overview and management console.</p>
    </div>
    
    <!-- Class Filter -->
    <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-100 min-w-[200px]">
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <select name="class_id" onchange="this.form.submit()" class="w-full bg-gray-50 border-none rounded-lg px-4 py-2 text-sm font-bold text-gray-700 focus:ring-0 cursor-pointer">
                <option value="">All Classes (Filter)</option>
                @foreach($all_classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Students</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['students']) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-green-500">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Total Teachers</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($stats['teachers']) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-red-500 relative">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Unread Messages</p>
        <div class="flex items-center gap-2 mt-1">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['unread_contacts'] }}</p>
            @if($stats['unread_contacts'] > 0)
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                </span>
            @endif
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-orange-500 relative">
        <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Pending Approvals</p>
        <div class="flex items-center gap-2 mt-1">
            <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_count'] }}</p>
            @if($stats['pending_count'] > 0)
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-600"></span>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
    <!-- Attendance Overview -->
    <div class="lg:col-span-3 flex flex-col">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Today's Attendance Overview</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-1">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Class Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Present</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Absent</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Total</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attendance_overview as $item)
                        @php
                            $percentage = $item['percentage'] ?? 0;
                            $badgeColor = $percentage >= 75 ? 'bg-green-100 text-green-700' : ($percentage >= 50 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700');
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-800 text-sm">{{ $item['class_name'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-green-600">{{ $item['present'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-red-600">{{ $item['absent'] }}</td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-500">{{ $item['total'] }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeColor }}">
                                    {{ $percentage }}%
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic text-sm">No attendance recorded today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="lg:col-span-2 flex flex-col">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Student Admissions</h3>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex-1">
            <div class="space-y-6">
                @forelse($recent_students as $student)
                <div class="flex items-center justify-between pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $student->user->name }}</p>
                        <p class="text-xs text-gray-400 font-medium mt-1">{{ $student->academicClass->name ?? 'Unassigned' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">
                            {{ \Carbon\Carbon::parse($student->created_at)->format('d M Y') }}
                        </p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 italic text-sm py-4">No recent registrations.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Pending Approvals Section -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">Pending Student Registrations</h3>
        <a href="{{ route('admin.pending-users') }}" class="text-[#2c3e80] text-sm font-bold hover:underline">View All</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Requested Class</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pending_registrations as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-blue-600">
                            {{ $user->student->academicClass->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('admin.approve-user', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 transition shadow-sm">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.reject-user', $user->id) }}" method="POST" onsubmit="return confirm('Reject this registration?')">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 transition shadow-sm">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic text-sm">No pending registrations.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Messages -->
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Unread Messages</h3>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Message Preview</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recent_contacts as $contact)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $contact->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 italic">"{{ Str::limit($contact->message, 50) }}"</td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">
                            {{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Unread</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="{{ route('admin.contacts.read', $contact->id) }}">
                                @csrf
                                <button type="submit" class="bg-[#2c3e80] text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                                    Mark Read
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic text-sm">No unread messages.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Links</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
        <a href="/admin/students" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Add Student</p>
        </a>
        <a href="/admin/teachers" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Add Teacher</p>
        </a>
        <a href="/admin/classes" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Manage Classes</p>
        </a>
        <a href="/admin/reports" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">View Reports</p>
        </a>
        <a href="/admin/timetable" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Timetable</p>
        </a>
        <a href="/admin/contacts" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">All Messages</p>
        </a>
        <a href="/admin/pending-users" class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center gap-3 transition hover:shadow-md hover:border-[#2c3e80] group text-center">
            <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest leading-tight">Pending Approvals</p>
        </a>
    </div>
</div>
@endsection
