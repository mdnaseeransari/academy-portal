@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Our Gallery</h1>
        <p class="text-lg text-gray-600 text-center mb-12">Moments from Optimal Classes</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @for ($i = 1; $i <= 12; $i++)
                <div class="bg-gray-200 rounded-lg overflow-hidden aspect-video flex items-center justify-center hover:shadow-lg transition">
                    <div class="text-center">
                        <p class="text-gray-500 text-lg">📷 Image {{ $i }}</p>
                        <p class="text-gray-400 text-sm">Coming Soon</p>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection