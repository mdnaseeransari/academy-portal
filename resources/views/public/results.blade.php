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
            <!-- 2025 Results -->
            <div id="year-2025" class="year-content animate-fade-in">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Academic Achievement 2025</h2>
                    <div class="w-20 h-1.5 bg-[#2c3e80] mx-auto rounded-full mt-4"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="group bg-white rounded-[3rem] p-10 shadow-xl border border-gray-100 hover:border-[#2c3e80]/20 transition-all duration-500">
                        <div class="flex items-center gap-6 mb-10">
                            <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-2xl flex items-center justify-center text-3xl shadow-lg">🎓</div>
                            <h3 class="text-3xl font-black text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-6">
                            <div class="bg-gray-50 rounded-3xl p-8 flex items-center justify-between group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-lg font-bold text-gray-600">Distinction (Above 90%)</span>
                                <span class="text-4xl font-black text-[#2c3e80]">06</span>
                            </div>
                            <div class="bg-gray-50 rounded-3xl p-8 flex items-center justify-between group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-lg font-bold text-gray-600">First Division (Above 80%)</span>
                                <span class="text-4xl font-black text-[#2c3e80]">14</span>
                            </div>
                        </div>
                    </div>
                    <div class="group bg-[#2c3e80] rounded-[3rem] p-10 shadow-2xl text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-10 text-white/5 text-9xl font-black select-none pointer-events-none">10</div>
                        <div class="relative z-10">
                            <div class="flex items-center gap-6 mb-10">
                                <div class="w-16 h-16 bg-white/10 backdrop-blur-md text-white rounded-2xl flex items-center justify-center text-3xl border border-white/20">🏆</div>
                                <h3 class="text-3xl font-black">Class 10 (Board)</h3>
                            </div>
                            <div class="space-y-6">
                                <div class="bg-white/10 rounded-3xl p-8 flex items-center justify-between border border-white/5">
                                    <span class="text-lg font-bold text-white/80">Merit (Above 95%)</span>
                                    <span class="text-4xl font-black text-white">03</span>
                                </div>
                                <div class="bg-white/10 rounded-3xl p-8 flex items-center justify-between border border-white/5">
                                    <span class="text-lg font-bold text-white/80">Distinction (Above 90%)</span>
                                    <span class="text-4xl font-black text-white">10</span>
                                </div>
                                <div class="bg-white/10 rounded-3xl p-8 flex items-center justify-between border border-white/5">
                                    <span class="text-lg font-bold text-white/80">First Division (Above 80%)</span>
                                    <span class="text-4xl font-black text-white">30</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2024-2022 contents follow same premium pattern but hidden initially -->
            @foreach([2024, 2023, 2022] as $y)
            <div id="year-{{ $y }}" class="year-content hidden animate-fade-in">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">Academic Achievement {{ $y }}</h2>
                    <div class="w-20 h-1.5 bg-[#2c3e80] mx-auto rounded-full mt-4"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div class="bg-white rounded-[3rem] p-10 shadow-xl border border-gray-100">
                        <div class="flex items-center gap-6 mb-10">
                            <div class="w-16 h-16 bg-[#2c3e80]/10 text-[#2c3e80] rounded-2xl flex items-center justify-center text-3xl font-black">12</div>
                            <h3 class="text-3xl font-black text-gray-800">Class 12</h3>
                        </div>
                        <div class="p-8 bg-gray-50 rounded-3xl">
                            <p class="text-gray-500 font-medium mb-2 uppercase tracking-widest text-xs">Overall Performance</p>
                            <p class="text-lg text-gray-700 leading-relaxed font-bold">Consistently maintaining a high success rate with multiple students scoring above 90% each year.</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-[3rem] p-10 shadow-xl border border-gray-100">
                        <div class="flex items-center gap-6 mb-10">
                            <div class="w-16 h-16 bg-[#2c3e80]/10 text-[#2c3e80] rounded-2xl flex items-center justify-center text-3xl font-black">10</div>
                            <h3 class="text-3xl font-black text-gray-800">Class 10</h3>
                        </div>
                        <div class="p-8 bg-gray-50 rounded-3xl">
                            <p class="text-gray-500 font-medium mb-2 uppercase tracking-widest text-xs">Foundation Success</p>
                            <p class="text-lg text-gray-700 leading-relaxed font-bold">Strong results in secondary boards, building a solid platform for future engineering and medical careers.</p>
                        </div>
                    </div>
                </div>
                <p class="text-center mt-12 text-gray-400 font-medium">Detailed student-wise lists are available in our academy gallery.</p>
            </div>
            @endforeach
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