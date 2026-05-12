<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just enter your username and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <!-- Username (Email) -->
        <div class="mb-4">
            <label for="email_username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <div class="flex rounded-lg shadow-sm">
                <input id="email_username" type="text" name="email_username" value="{{ old('email_username') }}" required autofocus placeholder="john_doe"
                    class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-lg text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('email_username') border-red-500 @enderror @error('email') border-red-500 @enderror">
                <span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm font-medium">
                    @gmail.com
                </span>
            </div>
            @error('email_username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
