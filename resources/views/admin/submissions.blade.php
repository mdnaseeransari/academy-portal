@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <nav class="flex mb-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.assignments') }}" class="text-sm font-medium text-gray-500 hover:text-[#2c3e80]">Assignments</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">Submissions</span>
                    </div>
                </li>
            </ol>
        </nav>
        <h1 class="text-2xl font-bold text-gray-800">{{ $assignment->title }}</h1>
        <p class="text-sm text-gray-500">Submissions received for this assignment</p>
    </div>
    <div class="text-right">
        <span class="bg-blue-50 text-[#2c3e80] text-xs px-3 py-1.5 rounded-lg font-bold border border-blue-100">
            Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, Y') }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Roll No</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted At</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">File</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Grade/Marks</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($assignment->submissions as $submission)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800">{{ $submission->student->user->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-600">{{ $submission->student->roll_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($submission->submitted_at)->format('d M, h:i A') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->file_path)
                                <a href="{{ $submission->file_url }}" target="_blank" class="inline-flex items-center gap-1 text-[#2c3e80] hover:underline font-bold text-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download
                                </a>
                            @else
                                <span class="text-xs text-gray-400 italic">No file</span>
                            @endif
                        </td>
                        <form action="{{ route('admin.submissions.updateMarks', $submission->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <td class="px-6 py-4">
                                <input type="text" name="grade" value="{{ $submission->grade }}" 
                                    class="w-20 border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80] text-sm py-1 px-2"
                                    placeholder="e.g. A, 90">
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button type="submit" class="bg-[#2c3e80] text-white px-3 py-1.5 rounded-lg hover:bg-[#1e2d5e] text-xs font-bold transition shadow-sm">
                                    Update
                                </button>
                            </td>
                        </form>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                            No submissions received yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
