@extends('layouts.app')

@push('sidebar-links')
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard
    </a>
    
    <!-- Students (Active) -->
    <a href="{{ route('admin.students') }}" class="flex items-center gap-3 px-4 py-2.5 text-white bg-white/20 rounded-lg mx-2 text-sm font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        Students
    </a>
    
    <!-- Teachers -->
    <a href="{{ route('admin.teachers') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        Teachers
    </a>
    
    <!-- Reports -->
    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg mx-2 text-sm transition">
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
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">All Students</h1>
        <p class="text-sm text-gray-500 font-medium">Manage student registrations and academic profiles.</p>
    </div>
    <button onclick="openAddModal()" class="bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add New Student
    </button>
</div>

<!-- Success Alert -->
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm font-medium animate-fade-in">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    {{ session('success') }}
</div>
@endif

<!-- Search and Filter Bar -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
    <form method="GET" action="{{ route('admin.students') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Search</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or roll number" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Class</label>
            <select name="class_filter" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                <option value="">All Classes</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $class_filter == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end gap-3">
            <button type="submit" class="flex-grow bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                Search
            </button>
            @if($search || $class_filter)
                <a href="{{ route('admin.students') }}" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-red-600 transition">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Students Table -->
<div class="mb-4">
    <p class="text-sm text-gray-500 italic">
        Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
    </p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Class</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Parent Phone</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Admission Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $index => $student)
                <tr class="hover:bg-gray-50 transition group" 
                    data-id="{{ $student->id }}"
                    data-name="{{ $student->user->name }}"
                    data-email="{{ $student->user->email }}"
                    data-class="{{ $student->academic_class_id }}"
                    data-roll="{{ $student->roll_number }}"
                    data-parent="{{ $student->parent_name }}"
                    data-phone="{{ $student->parent_phone }}"
                    data-address="{{ $student->address }}"
                    data-admission="{{ $student->admission_date }}"
                    data-active="{{ $student->user->is_active }}">
                    <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ $students->firstItem() + $index }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-[#2c3e80]">{{ $student->roll_number }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $student->user->name }}</div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase">{{ $student->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $student->academicClass->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $student->parent_phone }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ \Carbon\Carbon::parse($student->admission_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($student->user->is_active)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openViewModal(this.closest('tr'))" class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-gray-200 transition">View</button>
                            <button onclick="openEditModal(this.closest('tr'))" class="bg-[#2c3e80] text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1e2d5e] transition">Edit</button>
                            <form method="POST" action="{{ route('admin.students.delete', $student->id) }}" onsubmit="return confirm('Delete this student? All their data will be removed.')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-700 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic text-sm">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($students->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $students->links() }}
    </div>
    @endif
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" aria-hidden="true" onclick="closeModal('addStudentModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-2xl w-full mx-4 animate-scale-in">
            <div class="bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800" id="modal-title">Create New Student</h3>
                    <button onclick="closeModal('addStudentModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.students.add') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name*</label>
                            <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Enter student's full name">
                            @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email Address*</label>
                            <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="student@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Password*</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Set login password">
                            @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Class -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Select Class*</label>
                            <select name="academic_class_id" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                                <option value="">Select a class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('academic_class_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Roll Number -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Roll Number*</label>
                            <input type="text" name="roll_number" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="e.g. 2024-001">
                            @error('roll_number') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Admission Date -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Admission Date*</label>
                            <input type="date" name="admission_date" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                            @error('admission_date') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Parent Name -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Parent/Guardian Name*</label>
                            <input type="text" name="parent_name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Parent's full name">
                            @error('parent_name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Parent Phone -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Parent Phone Number*</label>
                            <input type="text" name="parent_phone" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="e.g. +91 9876543210">
                            @error('parent_phone') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Home Address</label>
                            <textarea name="address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Full residential address"></textarea>
                            @error('address') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-md">
                            Create Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editStudentModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" aria-hidden="true" onclick="closeModal('editStudentModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-2xl w-full mx-4 animate-scale-in">
            <div class="bg-white p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit Student Record</h3>
                    <button onclick="closeModal('editStudentModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name*</label>
                            <input type="text" name="name" id="edit_name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        
                        <!-- Email -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Email Address*</label>
                            <input type="email" name="email" id="edit_email" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>

                        <!-- Class -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Select Class*</label>
                            <select name="academic_class_id" id="edit_class" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Roll Number -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Roll Number*</label>
                            <input type="text" name="roll_number" id="edit_roll" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>

                        <!-- Admission Date -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Admission Date*</label>
                            <input type="date" name="admission_date" id="edit_admission" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>

                        <!-- Parent Name -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Parent/Guardian Name*</label>
                            <input type="text" name="parent_name" id="edit_parent" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>

                        <!-- Parent Phone -->
                        <div class="sm:col-span-1">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Parent Phone Number*</label>
                            <input type="text" name="parent_phone" id="edit_phone" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>

                        <!-- Address -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Home Address</label>
                            <textarea name="address" id="edit_address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition"></textarea>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-md">
                            Update Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Student Modal -->
<div id="viewStudentModal" class="fixed inset-0 z-[60] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" aria-hidden="true" onclick="closeModal('viewStudentModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-2xl w-full mx-4 animate-scale-in">
            <div class="bg-white p-6">
                <div class="flex items-center justify-between mb-8 border-b pb-4">
                    <h3 class="text-xl font-bold text-gray-800">Student Profile Details</h3>
                    <button onclick="closeModal('viewStudentModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Full Name</p>
                        <p id="view_name" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email Address</p>
                        <p id="view_email" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Roll Number</p>
                        <p id="view_roll" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Admission Date</p>
                        <p id="view_admission" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Parent/Guardian</p>
                        <p id="view_parent" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Phone Number</p>
                        <p id="view_phone" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Residential Address</p>
                        <p id="view_address" class="text-sm font-bold text-gray-800"></p>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t flex justify-end">
                    <button onclick="closeModal('viewStudentModal')" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-200 transition">
                        Close Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('addStudentModal').classList.remove('hidden');
}

function openEditModal(row) {
    const modal = document.getElementById('editStudentModal');
    const form = document.getElementById('editForm');
    
    // Pre-fill fields from data attributes
    document.getElementById('edit_name').value = row.dataset.name;
    document.getElementById('edit_email').value = row.dataset.email;
    document.getElementById('edit_class').value = row.dataset.class;
    document.getElementById('edit_roll').value = row.dataset.roll;
    document.getElementById('edit_parent').value = row.dataset.parent;
    document.getElementById('edit_phone').value = row.dataset.phone;
    document.getElementById('edit_address').value = row.dataset.address;
    document.getElementById('edit_admission').value = row.dataset.admission;
    
    // Set dynamic action URL
    form.action = '/admin/students/' + row.dataset.id;
    
    modal.classList.remove('hidden');
}

function openViewModal(row) {
    const modal = document.getElementById('viewStudentModal');
    
    document.getElementById('view_name').textContent = row.dataset.name;
    document.getElementById('view_email').textContent = row.dataset.email;
    document.getElementById('view_roll').textContent = row.dataset.roll;
    document.getElementById('view_parent').textContent = row.dataset.parent;
    document.getElementById('view_phone').textContent = row.dataset.phone;
    document.getElementById('view_address').textContent = row.dataset.address;
    
    // Format date for display
    const date = new Date(row.dataset.admission);
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    document.getElementById('view_admission').textContent = date.toLocaleDateString('en-GB', options);
    
    modal.classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

// Close modal when clicking outside
window.addEventListener('click', function(e) {
    ['addStudentModal','editStudentModal','viewStudentModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) modal.classList.add('hidden');
    });
});
</script>

<style>
@keyframes scale-in {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-scale-in {
    animation: scale-in 0.2s ease-out forwards;
}
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out forwards;
}
</style>
@endpush
