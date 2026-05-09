@extends('layouts.public')

@section('content')
<!-- Results Header Section -->
<div class="bg-[#2c3e80] py-20 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-white/5 opacity-50 pattern-dots"></div>
    <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in-up">
        <h1 class="text-4xl md:text-6xl font-black mb-6 drop-shadow-lg tracking-tight">Our Wall of Fame</h1>
        <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-medium">
            Celebrating the consistent excellence and hard work of our top performers.
        </p>
    </div>
</div>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-24">
        
        <!-- Year Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-20">
            @foreach([2025, 2024, 2023, 2022] as $year)
            <button 
                onclick="showYear({{ $year }})" 
                id="btn-{{ $year }}"
                class="year-btn px-10 py-4 rounded-2xl font-black transition-all duration-300 border-2 {{ $year == 2025 ? 'bg-[#2c3e80] text-white border-[#2c3e80] shadow-xl' : 'bg-white text-[#2c3e80] border-gray-100 hover:border-[#2c3e80]' }}">
                {{ $year }}
            </button>
            @endforeach
        </div>

        <div class="relative min-h-[400px]">
        <div class="relative min-h-[400px]">
            <!-- 2025 Results -->
            <div id="year-2025" class="year-content animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2024 - 2025</h2>
                    <div class="w-16 h-1 bg-[#2c3e80] mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Class 12 Board -->
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-sm font-medium text-gray-600">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">06</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-sm font-medium text-gray-600">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">14</span>
                            </div>
                        </div>
                    </div>

                    <!-- Class 10 Board -->
                    <div class="group bg-[#2c3e80] rounded-2xl p-6 shadow-xl text-white">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <h3 class="text-lg font-bold">Class 10 (Board)</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Merit (>95%)</span>
                                <span class="text-2xl font-bold text-white">03</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-white">10</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-white">30</span>
                            </div>
                        </div>
                    </div>

                    <!-- Competitive Exams -->
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#B8924A] text-white rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">JEE & NEET</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold mb-1">Impact</p>
                                <p class="text-sm text-gray-700 font-bold leading-relaxed">Multiple students qualified for IIT JEE Advanced and NEET 2024 with impressive ranks.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Previous Years -->
            <div id="year-2024" class="year-content hidden animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2023 - 2024</h2>
                    <div class="w-16 h-1 bg-gray-300 mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <span class="font-bold">12</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">05</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">16</span>
                            </div>
                        </div>
                    </div>
                    <div class="group bg-[#2c3e80] rounded-2xl p-6 shadow-xl text-white">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                                <span class="font-bold">10</span>
                            </div>
                            <h3 class="text-lg font-bold">Class 10 (Board)</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Merit (>95%)</span>
                                <span class="text-2xl font-bold text-white">01</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-white">04</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-white">18</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="year-2023" class="year-content hidden animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2022 - 2023</h2>
                    <div class="w-16 h-1 bg-gray-300 mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <span class="font-bold">12</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Merit (>95%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">01</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">03</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">10</span>
                            </div>
                        </div>
                    </div>
                    <div class="group bg-[#2c3e80] rounded-2xl p-6 shadow-xl text-white">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                                <span class="font-bold">10</span>
                            </div>
                            <h3 class="text-lg font-bold">Class 10 (Board)</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Merit (>95%)</span>
                                <span class="text-2xl font-bold text-white">01</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-white">03</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-white">12</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="year-2022" class="year-content hidden animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2021 - 2022</h2>
                    <div class="w-16 h-1 bg-gray-300 mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <span class="font-bold">12</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">04</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                                <span class="text-sm font-medium text-gray-600">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">08</span>
                            </div>
                        </div>
                    </div>
                    <div class="group bg-[#2c3e80] rounded-2xl p-6 shadow-xl text-white">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-white/10 backdrop-blur-md rounded-lg flex items-center justify-center border border-white/20">
                                <span class="font-bold">10</span>
                            </div>
                            <h3 class="text-lg font-bold">Class 10 (Board)</h3>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Merit (>95%)</span>
                                <span class="text-2xl font-bold text-white">01</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-white">02</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-white">08</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
function showYear(year) {
    // Hide all contents
    document.querySelectorAll('.year-content').forEach(el => el.classList.add('hidden'));
    // Show selected content
    document.getElementById('year-' + year).classList.remove('hidden');
    
    // Update button styles
    document.querySelectorAll('.year-btn').forEach(btn => {
        btn.classList.remove('bg-[#2c3e80]', 'text-white', 'border-[#2c3e80]', 'shadow-xl');
        btn.classList.add('bg-white', 'text-[#2c3e80]', 'border-gray-100');
    });
    
    const activeBtn = document.getElementById('btn-' + year);
    activeBtn.classList.add('bg-[#2c3e80]', 'text-white', 'border-[#2c3e80]', 'shadow-xl');
    activeBtn.classList.remove('bg-white', 'text-[#2c3e80]', 'border-gray-100');
}
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fade-in {
    animation: fade-in 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
.pattern-dots {
    background-image: radial-gradient(rgba(255, 255, 255, 0.2) 1px, transparent 1px);
    background-size: 30px 30px;
}
</style>
@endsection