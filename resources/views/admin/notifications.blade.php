@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Notification Bar Settings</h1>
        <p class="text-sm text-gray-500 font-medium">Create and manage the announcement banner displayed at the top of the homepage hero section.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6 shadow-sm">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add New Notification Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 h-fit">
            <h2 class="text-lg font-bold text-gray-800 mb-4">New Announcement</h2>
            <form method="POST" action="{{ route('admin.notifications.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea id="message" name="message" rows="4" required 
                              class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] shadow-sm transition"
                              placeholder="Type the announcement message here... (e.g. Admissions open for batch 2026-27! Register today.)"></textarea>
                </div>
                <button type="submit" class="w-full bg-[#2c3e80] text-white px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Save & Activate
                </button>
            </form>
        </div>

        <!-- Existing Notifications List -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Notification History</h2>
            <p class="text-xs text-gray-500 mb-6 font-medium">Note: Only the most recently added notification remains active. All other notifications are automatically deactivated.</p>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 text-xs font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3 px-4">Date Added</th>
                            <th class="py-3 px-4">Message</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($notifications as $notification)
                            <tr class="text-sm text-gray-700 hover:bg-gray-50/50 transition">
                                <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-500">
                                    {{ $notification->created_at->format('d M Y, h:i A') }}
                                </td>
                                <td class="py-4 px-4 max-w-xs md:max-w-sm truncate leading-relaxed">
                                    {{ $notification->message }}
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    @if($notification->is_active)
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-50 text-green-700 border border-green-100 animate-pulse">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-gray-50 text-gray-500 border border-gray-100">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}" 
                                          onsubmit="return confirm('Are you sure you want to permanently delete this notification?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                    No notifications created yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
