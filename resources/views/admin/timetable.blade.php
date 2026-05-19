@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Master Timetable Management</h1>
    <p class="text-sm text-gray-500 font-medium">Schedule classes, assign teachers, and manage academic slots.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
    <!-- Left: Add Entry Form -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#2c3e80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-9-4h18c1.104 0 2 .896 2 2v10c0 1.104-.896 2-2 2H3c-1.104 0-2-.896-2-2V7c0-1.104.896-2 2-2z"></path></svg>
                Add Timetable Entry
            </h3>
            
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-bold flex items-center gap-2 animate-fade-in">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-bold flex flex-col gap-2 animate-fade-in">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        <span>Please fix the following errors:</span>
                    </div>
                    <ul class="list-disc pl-8 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.timetable.add') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Select Class*</label>
                    <select name="academic_class_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        <option value="">Choose a class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('academic_class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Select Day*</label>
                    <select name="day" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        <option value="">Choose day</option>
                        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                            <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Subject Name*</label>
                    <input type="text" name="subject" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="e.g. Mathematics">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Assign Teacher*</label>
                    <select name="teacher_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        <option value="">Select teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->user_id }}" {{ old('teacher_id') == $teacher->user_id ? 'selected' : '' }}>{{ $teacher->user->name }} ({{ $teacher->subject }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Start Time*</label>
                        <input type="time" name="time_start" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">End Time*</label>
                        <input type="time" name="time_end" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-3 rounded-xl text-sm font-bold hover:bg-[#1e2d5e] transition shadow-md">
                        Add Timetable Entry
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right: View Timetable Grid -->
    <div class="lg:col-span-3 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <h3 class="text-lg font-bold text-gray-800">Weekly Schedule</h3>
                
                <form method="GET" action="{{ route('admin.timetable') }}" class="min-w-[200px]">
                    <select name="class_id" onchange="this.form.submit()" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm font-bold text-[#2c3e80] focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 transition">
                        <option value="">Select Class to View</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if($selected_class)
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b">Time Slot</th>
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                <th class="p-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b day-header" data-day="{{ $day }}">
                                    {{ $day }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $timeSlots = collect($timetable)->flatMap(fn($day) => $day)->pluck('time_start')->unique()->sort();
                        @endphp
                        
                        @forelse($timeSlots as $slot)
                        <tr>
                            <td class="p-4 text-xs font-bold text-gray-400 bg-gray-50/50">{{ \Carbon\Carbon::parse($slot)->format('h:i A') }}</td>
                            @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                @php
                                    $entry = collect($timetable[$day] ?? [])->firstWhere('time_start', $slot);
                                @endphp
                                <td class="p-4 border-l border-gray-50 align-top">
                                    @if($entry)
                                        <div class="bg-blue-50/50 rounded-lg p-2 relative group min-h-[60px]">
                                            <p class="text-xs font-bold text-[#2c3e80] mb-1">{{ $entry->subject }}</p>
                                            <p class="text-[9px] font-bold text-gray-500 uppercase">{{ $entry->teacher->name ?? 'Unknown' }}</p>
                                            
                                            <form method="POST" action="{{ route('admin.timetable.delete', $entry->id) }}" onsubmit="return confirm('Delete this entry?')" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-[10px] flex items-center gap-1 justify-center w-full transition">
                                                    ✕ Remove
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400 italic text-sm">No schedule entries found. Select a class and add slots.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-20 flex flex-col items-center justify-center text-center border-2 border-dashed border-gray-100 rounded-xl">
                <p class="text-gray-400 italic">Please select a class from the dropdown above to view the schedule.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toLocaleDateString('en-US', { weekday: 'long' });
    const headers = document.querySelectorAll('.day-header');
    
    headers.forEach(header => {
        if (header.dataset.day === today) {
            header.classList.add('bg-blue-50', 'text-[#2c3e80]');
            // Highlight the entire column
            const index = Array.from(header.parentNode.children).indexOf(header);
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const cell = row.children[index];
                if (cell) cell.classList.add('bg-blue-50/30');
            });
        }
    });
});
</script>
<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out forwards;
}
</style>
@endpush
