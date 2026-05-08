@extends('layouts.app')

@push('sidebar-links')
    @include('partials.admin-sidebar-links')
@endpush

@section('content')
<div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Messages & Inquiries</h1>
        <p class="text-sm text-gray-500 font-medium">Monitor and respond to student and public queries.</p>
    </div>
    <div class="mt-4 sm:mt-0 bg-blue-50 text-[#2c3e80] px-4 py-2 rounded-lg text-xs font-bold border border-blue-100 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Note: Messages will be automatically deleted after 10 days.
    </div>
</div>

<!-- Stats Bar -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-blue-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Messages</p>
        <p class="text-2xl font-bold text-gray-800">{{ $total_count }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-red-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Unread Queries</p>
        <p class="text-2xl font-bold text-gray-800">{{ $unread_count }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 border-l-4 border-orange-500">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Today's New</p>
        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Contact::where('created_at', '>=', now()->startOfDay())->count() }}</p>
    </div>
</div>

<!-- Search and Tabs -->
<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
    <div class="flex gap-2">
        <a href="{{ route('admin.contacts', ['tab' => 'unread']) }}" 
           class="px-5 py-2.5 rounded-lg text-sm font-bold transition {{ $tab == 'unread' ? 'bg-[#2c3e80] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-100 hover:bg-gray-50' }}">
            Unread ({{ $unread_count }})
        </a>
        <a href="{{ route('admin.contacts', ['tab' => 'all']) }}" 
           class="px-5 py-2.5 rounded-lg text-sm font-bold transition {{ $tab == 'all' ? 'bg-[#2c3e80] text-white shadow-md' : 'bg-white text-gray-600 border border-gray-100 hover:bg-gray-50' }}">
            All Messages
        </a>
    </div>
    
    <form method="GET" action="{{ route('admin.contacts') }}" class="flex-grow max-w-md">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="relative">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..." class="w-full bg-white border border-gray-200 rounded-xl px-5 py-2.5 pl-12 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80]/20 focus:border-[#2c3e80] shadow-sm transition">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </form>
</div>

<!-- Messages List -->
<div class="space-y-4">
    @forelse($contacts as $contact)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 transition hover:shadow-md {{ !$contact->is_read ? 'border-l-4 border-l-blue-500' : 'border-l-4 border-l-gray-200 opacity-85' }}">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <div>
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    {{ $contact->name }}
                    @if(!$contact->is_read)
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    @endif
                </h3>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-tighter">{{ $contact->email }} • {{ $contact->phone ?? 'No Phone' }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y, h:i A') }}</p>
            </div>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <p class="text-sm text-gray-600 leading-relaxed italic">"{{ $contact->message }}"</p>
        </div>
        
        <div class="flex justify-end gap-3">
            @if($contact->status === 'unread')
            <form method="POST" action="{{ route('admin.contacts.read', $contact->id) }}">
                @csrf
                <button type="submit" class="bg-[#2c3e80] text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-[#1e2d5e] transition shadow-sm">
                    Mark as Read
                </button>
            </form>
            @else
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-green-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    Read
                </span>
                <form method="POST" action="{{ route('admin.contacts.delete', $contact->id) }}" onsubmit="return confirm('Delete this message permanently?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition shadow-sm">
                        Delete
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white py-20 rounded-xl border border-dashed border-gray-300 flex flex-col items-center justify-center text-center">
        <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <p class="text-gray-400 italic">No messages found matching your criteria.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-8">
    {{ $contacts->links() }}
</div>
@endsection
