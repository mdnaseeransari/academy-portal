<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-6">
    <div class="max-w-md w-full bg-white rounded-lg shadow-sm border border-gray-100 p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l-2-2m0 0l-2-2m2 2l2-2m-2 2l-2 2"/>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Registration Rejected</h1>
        <p class="text-gray-600 mb-6">Your registration has been rejected by our admin team.</p>
        
        <p class="text-sm text-gray-500 mb-6">If you believe this is an error, please contact us at optimalclassesvns@gmail.com</p>
        
        <a href="{{ route('register') }}" class="inline-block bg-[#2c3e80] text-white px-6 py-2 rounded-lg hover:bg-[#1e2d5e] transition">← Try Registering Again</a>
    </div>
</div>
</x-guest-layout>
