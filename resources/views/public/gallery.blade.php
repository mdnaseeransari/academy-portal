@extends('layouts.public')
@section('title', 'Gallery | Classrooms & Campus Life | Optimal Classes Varanasi')
@section('meta_description', 'Photos of Optimal Classes Varanasi — smart digital classrooms, student life and campus facilities near Kakarmatta and DLW Colony.')
@section('meta_keywords', 'optimal classes gallery varanasi, coaching classrooms kakarmatta, optimal classes campus photos')

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
        

        <!-- Gallery Grid -->
        <div class="gallery-masonry">
            @php
                $newImages = ['1.webp', '2.webp', '4.webp', '5.webp', '6.webp', '7.webp', '8.webp', '9.webp', '10.webp', '11.webp', '12.webp', '13.webp', '14.webp'];
                $gallery = array_map(function ($img) {
                    $name = pathinfo($img, PATHINFO_FILENAME);
                    return [
                        'img' => $img,
                        'title' => ucwords(str_replace(['-', '_'], ' ', $name)),
                        'cat' => 'Gallery',
                    ];
                }, $newImages);
            @endphp

            @foreach($gallery as $item)
            <div class="gallery-item group relative bg-gray-100 shadow-lg hover:shadow-2xl transition-all duration-500 animate-fade-in">
                <img src="{{ asset('images/gallary/' . $item['img']) }}" class="gallery-masonry-img group-hover:scale-110 transition-transform duration-700" alt="Gallery image" loading="lazy" decoding="async">
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.gallery-masonry {
    column-count: 4;
    column-gap: 10px;
}
.gallery-item {
    display: inline-block;
    width: 100%;
    margin-bottom: 10px;
    break-inside: avoid;
    border-radius: 10px;
    overflow: hidden;
}
.gallery-masonry-img {
    width: 100%;
    height: auto;
    display: block;
}

/* Media Queries for responsive column count */
@media (max-width: 992px) {
    .gallery-masonry {
        column-count: 3;
    }
}
@media (max-width: 576px) {
    .gallery-masonry {
        column-count: 2;
    }
}

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