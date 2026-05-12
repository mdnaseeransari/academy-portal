<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label for="email_username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <div class="flex rounded-lg shadow-sm">
                <input id="email_username" type="text" name="email_username" value="{{ old('email_username') }}" required autocomplete="username" placeholder="john_doe"
                    class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-l-lg text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('email_username') border-red-500 @enderror">
                <span class="inline-flex items-center px-3 rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm font-medium">
                    @gmail.com
                </span>
            </div>
            @error('email_username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('password') border-red-500 @enderror">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent">
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (Optional)</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" minlength="10" maxlength="10" pattern="[0-9]{10}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('phone') border-red-500 @enderror">
            @error('phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Class -->
        <div class="mb-4">
            <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
            <select id="class_id" name="class_id" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('class_id') border-red-500 @enderror">
                <option value="">Select your class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            @error('class_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Parent Name -->
        <div class="mb-4">
            <label for="parent_name" class="block text-sm font-medium text-gray-700 mb-1">Parent's Name</label>
            <input id="parent_name" type="text" name="parent_name" value="{{ old('parent_name') }}" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('parent_name') border-red-500 @enderror">
            @error('parent_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Parent Phone -->
        <div class="mb-6">
            <label for="parent_phone" class="block text-sm font-medium text-gray-700 mb-1">Parent's Phone</label>
            <input id="parent_phone" type="tel" name="parent_phone" value="{{ old('parent_phone') }}" required minlength="10" maxlength="10" pattern="[0-9]{10}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2c3e80] focus:border-transparent @error('parent_phone') border-red-500 @enderror">
            @error('parent_phone')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-4">
            <button type="submit" class="w-full bg-[#2c3e80] text-white px-4 py-2.5 rounded-lg hover:bg-[#1e2d5e] transition font-bold text-sm">
                Create Account
            </button>
            
            <p class="text-center text-sm text-gray-500 mt-2">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-[#2c3e80] font-bold hover:underline">Login</a>
            </p>
        </div>
    </form>
</x-guest-layout>
