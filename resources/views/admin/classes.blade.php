@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Class Management</h2>
        <button onclick="document.getElementById('addClassModal').classList.remove('hidden')" class="bg-[#2c3e80] text-white px-4 py-2 rounded-lg hover:bg-[#1e2d5e] transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Class
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
    @endif

    <!-- Search Bar -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.classes') }}" class="flex gap-4">
            <div class="flex-grow">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search classes by name" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Search
                </button>
                @if(isset($search) && $search)
                    <a href="{{ route('admin.classes') }}" class="px-5 py-2.5 text-sm font-bold text-gray-500 hover:text-red-600 transition">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Classes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($classes as $class)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $class->name }}</h3>
                    <div class="flex space-x-2">
                        <button onclick="openEditModal({{ $class->id }}, '{{ $class->name }}', '{{ $class->teacher_id }}')" class="text-blue-500 hover:text-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <form action="{{ route('admin.classes.delete', $class->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this class?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-gray-600">
                        <span class="text-sm">Teacher: {{ $class->teacher->name ?? 'Unassigned' }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-sm">Students: {{ $class->students->count() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Add Class Modal -->
<div id="addClassModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Add New Class</h3>
            <button onclick="document.getElementById('addClassModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.classes.add') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                    <input type="text" name="class_name" required class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80]" placeholder="e.g. Class 10th">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teacher (Optional)</label>
                    <select name="teacher_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80]">
                        <option value="">Select Teacher</option>
                        @php $teachers = \App\Models\User::where('role', 'teacher')->get(); @endphp
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('addClassModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#2c3e80] text-white rounded-lg hover:bg-[#1e2d5e]">Save Class</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Class Modal -->
<div id="editClassModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Edit Class</h3>
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="editClassForm" method="POST" class="p-6">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class Name</label>
                    <input type="text" id="edit_class_name" name="class_name" required class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teacher</label>
                    <select id="edit_teacher_id" name="teacher_id" class="w-full border-gray-300 rounded-lg focus:ring-[#2c3e80] focus:border-[#2c3e80]">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#2c3e80] text-white rounded-lg hover:bg-[#1e2d5e]">Update Class</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, teacherId) {
    document.getElementById('edit_class_name').value = name;
    document.getElementById('edit_teacher_id').value = teacherId;
    document.getElementById('editClassForm').action = `/admin/classes/${id}`;
    document.getElementById('editClassModal').classList.remove('hidden');
    document.getElementById('editClassModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editClassModal').classList.add('hidden');
    document.getElementById('editClassModal').style.display = '';
}
</script>
@endsection
