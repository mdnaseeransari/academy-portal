@extends('layouts.public')

@section('content')
<!-- Gallery Header Section -->
<div class="bg-[#2c3e80] py-20 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-white/5 opacity-50 pattern-dots"></div>
    <div class="container mx-auto px-6 text-center relative z-10 animate-fade-in-up">
        <h1 class="text-4xl md:text-6xl font-black mb-6 drop-shadow-lg tracking-tight">Visions of Excellence</h1>
        <p class="text-xl md:text-2xl text-white/80 max-w-3xl mx-auto leading-relaxed font-medium">
            Explore our state-of-the-art facilities, dynamic classrooms, and memorable campus moments.
        </p>
    </div>
</div>

<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-24">
        
        <!-- Gallery Filters -->
        <div class="flex flex-wrap justify-center gap-4 mb-20">
            @foreach(['All', 'Infrastructure', 'Classrooms', 'Events', 'Achievements'] as $cat)
            <button class="px-8 py-3 rounded-2xl font-black transition-all duration-300 border-2 {{ $cat == 'All' ? 'bg-[#2c3e80] text-white border-[#2c3e80] shadow-lg' : 'bg-white text-[#2c3e80] border-gray-100 hover:border-[#2c3e80]' }}">
                {{ $cat }}
            </button>
            @endforeach
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @php
                $gallery = [
                    ['img' => 'bg-optimal-classes.jpg', 'title' => 'Main Campus Entrance', 'cat' => 'Infrastructure'],
                    ['img' => 'download (1).jpg', 'title' => 'Digital Classroom Setup', 'cat' => 'Classrooms'],
                    ['img' => 'download (2).jpg', 'title' => 'Annual Science Fair', 'cat' => 'Events'],
                    ['img' => 'download.jpg', 'title' => 'Practical Labs', 'cat' => 'Infrastructure'],
                    ['img' => 'photo.jpeg', 'title' => 'Student Seminar', 'cat' => 'Events'],
                ];
            @endphp

            @foreach($gallery as $item)
            <div class="group relative bg-gray-100 rounded-[2rem] overflow-hidden aspect-square shadow-lg hover:shadow-2xl transition-all duration-500 animate-fade-in">
                <img src="{{ asset('images/' . $item['img']) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $item['title'] }}">
                <div class="absolute inset-0 bg-gradient-to-t from-[#2c3e80] via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                    <span class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-1">{{ $item['cat'] }}</span>
                    <h4 class="text-white font-black text-xl leading-tight">{{ $item['title'] }}</h4>
                </div>
            </div>
            @endforeach

            @for ($i = 6; $i <= 12; $i++)
            <div class="group relative bg-gray-50 rounded-[2rem] overflow-hidden aspect-square border-2 border-dashed border-gray-200 flex items-center justify-center animate-fade-in">
                <div class="text-center group-hover:scale-110 transition-transform duration-300">
                    <div class="text-4xl mb-2 grayscale opacity-30">📷</div>
                    <p class="text-gray-400 font-black text-sm uppercase tracking-widest">Image {{ $i }}</p>
                    <p class="text-gray-300 text-[10px] font-bold">COMING SOON</p>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fade-in 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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