@extends('layouts.public')
@section('title', 'Student Results & Toppers | Board, IIT JEE, NEET | Optimal Classes Varanasi')
@section('meta_description', 'Optimal Classes students consistently score 90%+ in Board exams. 100+ toppers from Kakarmatta, DLW, Varanasi in Class 10, Class 12, IIT JEE and NEET.')
@section('meta_keywords', 'optimal classes results varanasi, board exam toppers kakarmatta, IIT JEE NEET results varanasi coaching')

@section('content')
<!-- Results Header Section -->
<div class="bg-[#2c3e80] py-20 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-white/5 opacity-50 pattern-dots"></div>
    <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in-up">
        <h1 class="text-4xl md:text-6xl font-black mb-6 drop-shadow-lg tracking-tight">Our Wall of Fame</h1>
        <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-medium">
            Celebrating the consistent excellence and hard work of our top performers.
        </p>
        
        @php
            $fameDir = public_path('images/fame');
            $files = is_dir($fameDir) ? scandir($fameDir) : [];
            $class12 = [];
            $class10 = [];
            
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                if (strpos($file, 'fame') === false) continue;
                
                // Group 1: filenames containing "12" or "xii" or "XII" -> Class XII
                // Group 2: filenames containing "10" or "x" or "X" -> Class X
                // Handle overlap like fame (12) class 10.webp correctly by looking at the class label first
                $isClass10 = (strpos($file, '10') !== false || stripos($file, 'x') !== false) && (strpos($file, 'class 12') === false && strpos($file, 'class12') === false);
                $isClass12 = (strpos($file, '12') !== false || stripos($file, 'xii') !== false) && (strpos($file, 'class 10') === false && strpos($file, 'class10') === false);
                
                if ($isClass12) {
                    $class12[] = $file;
                } elseif ($isClass10) {
                    $class10[] = $file;
                }
            }
            
            // Sort arrays alphabetically for consistent order
            sort($class12);
            sort($class10);
        @endphp

        <!-- Student Photo Grid Section -->
        <div class="fame-grid mt-16 mb-12 animate-fade-in-up">
            @foreach($class12 as $file)
                <div class="fame-card">
                    <img src="{{ asset('images/fame/' . $file) }}" class="fame-image" alt="Class XII Top Scorer" loading="lazy">
                </div>
            @endforeach
            @foreach($class10 as $file)
                <div class="fame-card">
                    <img src="{{ asset('images/fame/' . $file) }}" class="fame-image" alt="Class X Top Scorer" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-24">
        
        <!-- Year Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-20">
            @foreach([2026, 2025, 2024, 2023, 2022] as $year)
            <button 
                onclick="showYear({{ $year }})" 
                id="btn-{{ $year }}"
                class="year-btn px-10 py-4 rounded-2xl font-black transition-all duration-300 border-2 {{ $year == 2026 ? 'bg-[#2c3e80] text-white border-[#2c3e80] shadow-xl' : 'bg-white text-[#2c3e80] border-gray-100 hover:border-[#2c3e80]' }}">
                {{ $year }}
            </button>
            @endforeach
        </div>

        <div class="relative min-h-[400px]">
        <div class="relative min-h-[400px]">
            <!-- 2026 Results -->
            <div id="year-2026" class="year-content animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2025 - 2026</h2>
                    <div class="w-16 h-1 bg-[#2c3e80] mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <!-- Class 12 Board -->
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <span class="font-bold">12</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Class 12 (Board)</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-sm font-medium text-gray-600">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">01</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl group-hover:bg-[#2c3e80]/5 transition-colors">
                                <span class="text-sm font-medium text-gray-600">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-[#2c3e80]">18</span>
                            </div>
                        </div>
                    </div>

                    <!-- Class 10 Board -->
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
                                <span class="text-2xl font-bold text-white">02</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">Distinction (>90%)</span>
                                <span class="text-2xl font-bold text-white">07</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl border border-white/5">
                                <span class="text-sm font-medium text-white/80">First Div (>80%)</span>
                                <span class="text-2xl font-bold text-white">31</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2025 Results -->
            <div id="year-2025" class="year-content hidden animate-fade-in">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight italic">Session 2024 - 2025</h2>
                    <div class="w-16 h-1 bg-[#2c3e80] mx-auto rounded-full mt-3"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <!-- Class 12 Board -->
                    <div class="group bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-[#2c3e80] text-white rounded-lg flex items-center justify-center">
                                <span class="font-bold">12</span>
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
                                <span class="font-bold">10</span>
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
.fame-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 16px;
    width: 90%;
    margin-left: auto;
    margin-right: auto;
    margin-top: 40px;
}

@media (max-width: 992px) {
    .fame-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 576px) {
    .fame-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

.fame-card {
    border-radius: 12px;
    aspect-ratio: 3/4;
    overflow: hidden;
}

.fame-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

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

<div class="container mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Why Our Results Speak for Themselves
    </h2>
    <p class="text-gray-600 mb-4">
        At Optimal Classes, Kakarmatta Varanasi, our students 
        consistently achieve outstanding results in CBSE and ICSE 
        board examinations. From Anas Siddiqui scoring 96% to 
        Khushi Yadav, Anant Srivastava and Khushi Raj all scoring 
        96.2% — our toppers speak for themselves.
    </p>
    <p class="text-gray-600 mb-4">
        In Session 2025-26, Kartikey Tripathi scored 94.6% in 
        Class XII PCM, Harshit Tiwari scored 92% in Class X, 
        Arohi Rai scored 91.6% and multiple students crossed 
        90% in both Class 10 and Class 12 boards.
    </p>
    <p class="text-gray-600 mb-4">
        Our structured approach combining weekly Sunday tests, 
        dedicated doubt sessions and customized study material 
        ensures every student from Kakarmatta, DLW, BLW, 
        Sunderpur and across Varanasi reaches their full potential.
    </p>
    <p class="text-gray-600">
        Join the growing list of 100+ toppers who have achieved 
        their dreams with Optimal Classes.
    </p>
</div>
@endsection