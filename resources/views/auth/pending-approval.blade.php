<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-6">
    <div class="max-w-md w-full bg-white rounded-lg shadow-sm border border-gray-100 p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pending Approval</h1>
        <p class="text-gray-600 mb-6">Your registration is being reviewed by our admin team. You will be able to login once your account is approved.</p>
        
        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ $errors->first() }}
            </div>
        @endif
        
        <p class="text-sm text-gray-500 mb-6">This typically takes 24-48 hours.</p>
        
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('login') }}" class="inline-block bg-white text-[#2c3e80] border border-[#2c3e80] px-6 py-2 rounded-lg hover:bg-gray-50 transition">← Back to Login</a>
            <a href="{{ url('/') }}" class="inline-block bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition">Go to Homepage →</a>
        </div>
    </div>
</div>
</x-guest-layout>
