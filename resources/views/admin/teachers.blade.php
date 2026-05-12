@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">All Teachers</h1>
        <p class="text-sm text-gray-500 font-medium">Manage faculty members and class assignments.</p>
    </div>
    <button onclick="openAddModal()" class="bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add New Teacher
    </button>
</div>

<!-- Success Alert -->
@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-3 text-sm font-medium animate-fade-in">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
    {{ session('success') }}
</div>
@endif

<!-- Search Bar -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
    <form method="GET" action="{{ route('admin.teachers') }}" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-grow">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Search Faculty</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email or subject" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
        </div>
        <div class="flex items-end gap-3">
            <button type="submit" class="bg-[#2c3e80] text-white px-8 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                Search
            </button>
            @if($search)
                <a href="{{ route('admin.teachers') }}" class="px-4 py-2.5 text-sm font-bold text-gray-500 hover:text-red-600 transition">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Teachers Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Qualification</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Class Assigned</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($teachers as $index => $teacher)
                <tr class="hover:bg-gray-50 transition" 
                    data-id="{{ $teacher->id }}"
                    data-name="{{ $teacher->user->name }}"
                    data-email="{{ $teacher->user->email }}"
                    data-subject="{{ $teacher->subject }}"
                    data-phone="{{ $teacher->phone }}"
                    data-qualification="{{ $teacher->qualification }}"
                    data-class="{{ $teacher->classes->first()->id ?? '' }}">
                    <td class="px-6 py-4 text-sm font-bold text-gray-400">{{ $teachers->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $teacher->user->name }}</div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase">{{ $teacher->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-[#2c3e80]">{{ $teacher->subject }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $teacher->phone }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-600">{{ $teacher->qualification ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-600">{{ $teacher->classes->first()->name ?? 'None' }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($teacher->user->is_active)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-red-100 text-red-700">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openViewModal(this.closest('tr'))" class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-gray-200 transition">View</button>
                            <button onclick="openEditModal(this.closest('tr'))" class="bg-[#2c3e80] text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1e2d5e] transition shadow-sm">Edit</button>
                            <form method="POST" action="{{ route('admin.teachers.delete', $teacher->id) }}" onsubmit="return confirm('Delete this teacher?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-700 transition shadow-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400 italic text-sm">No teachers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($teachers->hasPages())
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        {{ $teachers->links() }}
    </div>
    @endif
</div>

<!-- Add Teacher Modal -->
<div id="addTeacherModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" onclick="closeModal('addTeacherModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-2xl w-full mx-4 animate-scale-in">
            <div class="bg-white p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-800">Add New Teacher</h3>
                    <button onclick="closeModal('addTeacherModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.teachers.add') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">First Name*</label>
                            <input type="text" name="first_name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="First Name">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Last Name*</label>
                            <input type="text" name="last_name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Last Name">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Username*</label>
                            <div class="flex rounded-lg shadow-sm">
                                <input type="text" name="email_username" required class="flex-1 min-w-0 block w-full bg-gray-50 border border-gray-200 rounded-none rounded-l-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="e.g. jdoe">
                                <span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-gray-200 bg-gray-100 text-gray-500 text-xs font-bold">
                                    @gmail.com
                                </span>
                            </div>
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Phone Number*</label>
                            <input type="tel" name="phone" required minlength="10" maxlength="10" pattern="[0-9]{10}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Phone (10 digits)">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Password*</label>
                            <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="••••••••">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="••••••••">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Subject*</label>
                            <input type="text" name="subject" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition" placeholder="Primary Subject">
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-md">
                            Create Teacher Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div id="editTeacherModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" onclick="closeModal('editTeacherModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-2xl w-full mx-4 animate-scale-in">
            <div class="bg-white p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-gray-800">Edit Teacher Details</h3>
                    <button onclick="closeModal('editTeacherModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name*</label>
                            <input type="text" name="name" id="edit_name" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email Address*</label>
                            <input type="email" name="email" id="edit_email" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Subject*</label>
                            <input type="text" name="subject" id="edit_subject" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Phone Number*</label>
                            <input type="tel" name="phone" id="edit_phone" required minlength="10" maxlength="10" pattern="[0-9]{10}" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Qualification</label>
                            <input type="text" name="qualification" id="edit_qualification" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                        </div>
                        <div class="sm:col-span-1">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Assign Class</label>
                            <select name="academic_class_id" id="edit_class" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] transition">
                                <option value="">None</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-3 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-md">
                            Update Teacher Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Teacher Modal -->
<div id="viewTeacherModal" class="fixed inset-0 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50 backdrop-blur-sm" onclick="closeModal('viewTeacherModal')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle max-w-lg w-full mx-4 animate-scale-in">
            <div class="bg-white p-8">
                <div class="flex items-center justify-between mb-8 border-b pb-4">
                    <h3 class="text-xl font-bold text-gray-800">Teacher Profile</h3>
                    <button onclick="closeModal('viewTeacherModal')" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Full Name</p>
                        <p id="view_name" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email Address</p>
                        <p id="view_email" class="text-sm font-bold text-gray-800"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Subject Expertise</p>
                        <p id="view_subject" class="text-sm font-bold text-[#2c3e80]"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Phone</p>
                            <p id="view_phone" class="text-sm font-bold text-gray-800"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Assigned Class</p>
                            <p id="view_class" class="text-sm font-bold text-gray-800"></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Qualification</p>
                        <p id="view_qualification" class="text-sm font-bold text-gray-800"></p>
                    </div>
                </div>
                <div class="mt-10">
                    <button onclick="closeModal('viewTeacherModal')" class="w-full bg-gray-100 text-gray-600 px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-gray-200 transition">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openAddModal() {
    document.getElementById('addTeacherModal').classList.remove('hidden');
}

function openEditModal(row) {
    const modal = document.getElementById('editTeacherModal');
    const form = document.getElementById('editForm');
    
    document.getElementById('edit_name').value = row.dataset.name;
    document.getElementById('edit_email').value = row.dataset.email;
    document.getElementById('edit_subject').value = row.dataset.subject;
    document.getElementById('edit_phone').value = row.dataset.phone;
    document.getElementById('edit_qualification').value = row.dataset.qualification;
    document.getElementById('edit_class').value = row.dataset.class;
    
    form.action = '/admin/teachers/' + row.dataset.id;
    modal.classList.remove('hidden');
}

function openViewModal(row) {
    const modal = document.getElementById('viewTeacherModal');
    
    document.getElementById('view_name').textContent = row.dataset.name;
    document.getElementById('view_email').textContent = row.dataset.email;
    document.getElementById('view_subject').textContent = row.dataset.subject;
    document.getElementById('view_phone').textContent = row.dataset.phone;
    document.getElementById('view_qualification').textContent = row.dataset.qualification || 'N/A';
    
    const classText = row.querySelector('td:nth-child(6)').textContent;
    document.getElementById('view_class').textContent = classText;
    
    modal.classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

window.addEventListener('click', function(e) {
    ['addTeacherModal','editTeacherModal','viewTeacherModal'].forEach(id => {
        const modal = document.getElementById(id);
        if (e.target === modal) modal.classList.add('hidden');
    });
});
</script>
<style>
@keyframes scale-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-scale-in {
    animation: scale-in 0.2s ease-out forwards;
}
</style>
@endpush
