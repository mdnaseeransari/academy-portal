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
        <div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-gray-800">Attendance Overview</h3>
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2">
                @if(isset($selected_class_id))
                    <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                @endif
                <label class="sr-only">Date</label>
                <input type="date" name="date" value="{{ $selected_date ?? date('Y-m-d') }}" onchange="this.form.submit()"
                       class="border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:ring-[#2c3e80] focus:border-[#2c3e80] text-gray-700 bg-white shadow-sm font-semibold">
            </form>
        </div>
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
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic text-sm">No attendance recorded for this date.</td>
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
@endsection
