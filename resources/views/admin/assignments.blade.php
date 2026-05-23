@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manage Assignments</h1>
        <p class="text-sm text-gray-500">Upload and manage assignments for the selected class.</p>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Shared Class Filter -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('admin.assignments') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
        <div class="flex-grow w-full sm:w-auto">
            <label class="block text-sm font-bold text-gray-700 mb-2">Select Class</label>
            <select name="class_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm transition" onchange="this.form.submit()">
                @if($classes->isEmpty())
                    <option value="">No classes available</option>
                @endif
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $selected_class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm h-10 w-full sm:w-auto">
            Load
        </button>
    </form>
</div>

@if($selected_class_id)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upload Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Upload New Assignment</h3>
                </div>
                <form action="{{ route('admin.assignments.create') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <input type="hidden" name="class_id" value="{{ $selected_class_id }}">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]" placeholder="Assignment Title">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Description (Optional)</label>
                        <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]" placeholder="Instructions..."></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" required min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80]">
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-1">Attachment (Optional)</label>
                        <input type="file" name="file" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-[#2c3e80] focus:border-[#2c3e80] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-[#2c3e80] hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, JPG, PNG up to 5MB</p>
                    </div>
                    
                    <button type="submit" class="w-full bg-[#2c3e80] text-white px-4 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm shadow-md">
                        Upload Assignment
                    </button>
                </form>
            </div>
        </div>

        <!-- Assignments List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Current Assignments</h3>
                    <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">Total: {{ $assignments->count() }}</p>
                </div>
                
                <div class="p-6 space-y-6">
                    @forelse($assignments as $assignment)
                        <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col w-full overflow-hidden">
                            <!-- Top Header Row -->
                            <div class="flex flex-col gap-2 md:flex-row md:justify-between md:items-start mb-2 w-full">
                                <h4 class="text-2xl font-bold text-gray-800 tracking-tight leading-tight break-all overflow-wrap-anywhere w-full">{{ $assignment->title }}</h4>
                                <span class="flex-shrink-0 bg-blue-50/70 border border-blue-100 text-[#1e3a8a] text-xs font-bold px-3 py-1.5 rounded-full whitespace-nowrap">
                                    {{ $assignment->submissions_count }} submissions
                                </span>
                            </div>

                            <!-- Subtitle Info -->
                            <div class="flex items-center flex-wrap gap-2 text-xs text-gray-400 font-semibold mb-4">
                                <span class="bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded text-[10px] uppercase font-bold tracking-widest">
                                    {{ $assignment->academicClass->name ?? 'Class' }}
                                </span>
                                <span>Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, Y') }}</span>
                                <span class="mx-1">|</span>
                                <span>Assigned by: <strong class="text-[#1e3a8a] font-bold">{{ $assignment->creator->name ?? 'Admin User' }}</strong></span>
                            </div>

                            @if($assignment->description)
                                <p class="text-sm text-gray-600 mt-2 mb-6 leading-relaxed">{{ $assignment->description }}</p>
                            @else
                                <div class="mt-2 mb-6"></div>
                            @endif

                            <!-- Bottom Row with Actions -->
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-t border-gray-100 pt-5 mt-auto">
                                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3 w-full sm:w-auto">
                                    <a href="{{ route('admin.assignments.submissions', $assignment->id) }}" class="bg-[#2c3e80] text-white px-5 py-2.5 rounded-xl hover:bg-[#1e2d5e] transition text-xs font-bold shadow-sm flex items-center justify-center gap-2 w-full sm:w-auto">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View Submissions
                                    </a>

                                    @if($assignment->file_path)
                                        <a href="{{ $assignment->file_path }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center justify-center gap-1 px-5 py-2.5 bg-blue-50 rounded-xl hover:bg-blue-100 transition w-full sm:w-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            Attachment
                                        </a>
                                    @endif
                                </div>

                                <form action="{{ route('admin.assignments.delete', $assignment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment and all its submissions?');" class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-5 py-2.5 rounded-xl hover:bg-red-400 transition text-xs font-bold shadow-sm w-full">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-400 italic font-medium">No assignments found for this class.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@else
    <div class="py-20 text-center bg-white rounded-xl border border-gray-100 shadow-sm">
        <p class="text-gray-400 font-medium italic">Please select a class to view or upload assignments.</p>
    </div>
@endif

@endsection
