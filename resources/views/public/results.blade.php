@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Our Achievers</h1>
        <p class="text-lg text-gray-600 text-center mb-12">Best Performance Students in Academic Years</p>

        <!-- Year Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button onclick="showYear(2025)" class="px-6 py-2 rounded-lg font-bold bg-[#2c3e80] text-white">2025</button>
            <button onclick="showYear(2024)" class="px-6 py-2 rounded-lg font-bold border-2 border-[#2c3e80] text-[#2c3e80]">2024</button>
            <button onclick="showYear(2023)" class="px-6 py-2 rounded-lg font-bold border-2 border-[#2c3e80] text-[#2c3e80]">2023</button>
            <button onclick="showYear(2022)" class="px-6 py-2 rounded-lg font-bold border-2 border-[#2c3e80] text-[#2c3e80]">2022</button>
        </div>

        <!-- 2025 Results -->
        <div id="year-2025" class="mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Academic 2025</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border-2 border-[#2c3e80]">
                    <h3 class="text-2xl font-bold text-[#2c3e80] mb-6">Class 12</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">6 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">14 Students</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border-2 border-green-600">
                    <h3 class="text-2xl font-bold text-green-700 mb-6">Class 10</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 95%:</span>
                            <span class="text-2xl font-bold text-green-600">3 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-green-600">10 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-green-600">30 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2024 Results -->
        <div id="year-2024" class="mb-12 hidden">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Academic 2024</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border-2 border-[#2c3e80]">
                    <h3 class="text-2xl font-bold text-[#2c3e80] mb-6">Class 12</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">5 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">16 Students</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border-2 border-green-600">
                    <h3 class="text-2xl font-bold text-green-700 mb-6">Class 10</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 95%:</span>
                            <span class="text-2xl font-bold text-green-600">1 Student</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-green-600">4 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-green-600">18 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2023 Results -->
        <div id="year-2023" class="mb-12 hidden">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Academic 2023</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border-2 border-[#2c3e80]">
                    <h3 class="text-2xl font-bold text-[#2c3e80] mb-6">Class 12</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 95%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">1 Student</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">3 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">10 Students</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border-2 border-green-600">
                    <h3 class="text-2xl font-bold text-green-700 mb-6">Class 10</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 95%:</span>
                            <span class="text-2xl font-bold text-green-600">1 Student</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-green-600">3 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-green-600">12 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2022 Results -->
        <div id="year-2022" class="mb-12 hidden">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Academic 2022</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-8 border-2 border-[#2c3e80]">
                    <h3 class="text-2xl font-bold text-[#2c3e80] mb-6">Class 12</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">4 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-[#2c3e80]">8 Students</span>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-8 border-2 border-green-600">
                    <h3 class="text-2xl font-bold text-green-700 mb-6">Class 10</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 95%:</span>
                            <span class="text-2xl font-bold text-green-600">1 Student</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 90%:</span>
                            <span class="text-2xl font-bold text-green-600">2 Students</span>
                        </div>
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Score above 80%:</span>
                            <span class="text-2xl font-bold text-green-600">8 Students</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showYear(year) {
    // Hide all
    document.getElementById('year-2025').classList.add('hidden');
    document.getElementById('year-2024').classList.add('hidden');
    document.getElementById('year-2023').classList.add('hidden');
    document.getElementById('year-2022').classList.add('hidden');
    
    // Show selected
    document.getElementById('year-' + year).classList.remove('hidden');
}
</script>
@endsection