<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Optimal Classes - Authentication</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#2c3e80] text-gray-900">
    <div class="min-h-screen flex flex-col justify-center items-center px-6 py-12">
        <div class="w-full sm:max-w-md bg-white rounded-xl shadow-xl border border-gray-100 p-8 overflow-hidden">
            <div class="flex flex-col items-center mb-8">
                <span class="text-2xl font-bold text-[#2c3e80]">Optimal Classes</span>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>
