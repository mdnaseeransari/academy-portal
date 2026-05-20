@extends('layouts.public')
@section('title', 'Courses & Fee 2026-27 | Class 6-12, IIT JEE, NEET | Optimal Classes Varanasi')
@section('meta_description', 'Coaching fee for Class 6-12, IIT JEE and NEET at Optimal Classes Kakarmatta Varanasi. Session 2026-27 starts at ₹22,200 with easy installments available.')
@section('meta_keywords', 'coaching fee varanasi, IIT JEE coaching fee varanasi, NEET coaching fee kakarmatta, class 6 to 12 fee varanasi')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Courses & Fee Structure</h1>
        <p class="text-lg text-gray-600 text-center mb-12">Session 2026-27</p>

        <!-- Classes 6-10 -->
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-12 h-12 bg-[#2c3e80] text-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Secondary Division (Class 6 - 10)</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @php
                    $secondaryCourses = [
                        ['title' => 'Pre-Foundation', 'class' => 'Class VI', 'desc' => 'Build a strong Pre-foundation with our tailored program.', 'fee' => '22,200', 'inst' => ['8,880', '8,880', '4,440']],
                        ['title' => 'Foundation', 'class' => 'Class VII', 'desc' => 'Build a strong foundation with our tailored program.', 'fee' => '22,200', 'inst' => ['8,880', '8,880', '4,440']],
                        ['title' => 'Spark', 'class' => 'Class VIII', 'desc' => 'Ignite the spark of learning with our advanced curriculum.', 'fee' => '22,200', 'inst' => ['8,880', '8,880', '4,440']],
                        ['title' => 'Maverick', 'class' => 'Class IX', 'desc' => 'Empower young minds to excel with comprehensive learning.', 'fee' => '30,000', 'inst' => ['12,000', '12,000', '6,000']],
                        ['title' => 'Ace', 'class' => 'Class X', 'desc' => 'Achieve excellence and ace your board exams with expert guidance.', 'fee' => '30,000', 'inst' => ['12,000', '12,000', '6,000']],
                    ];
                @endphp

                @foreach($secondaryCourses as $course)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#2c3e80]/60 mb-2 block">{{ $course['class'] }}</span>
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">{{ $course['title'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">{{ $course['desc'] }}</p>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="bg-gray-50 rounded-2xl p-6 group-hover:bg-[#2c3e80]/5 transition-colors duration-300">
                            <div class="flex items-baseline gap-1 mb-4">
                                <span class="text-gray-400 text-sm font-bold">₹</span>
                                <span class="text-3xl font-black text-[#2c3e80]">{{ $course['fee'] }}</span>
                                <span class="text-gray-400 text-xs font-medium ml-1">/ session</span>
                            </div>
                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                @foreach($course['inst'] as $index => $amt)
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-500 font-medium">Installment {{ $index + 1 }}</span>
                                    <span class="font-bold text-gray-800">₹{{ $amt }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Classes 11-12 -->
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="w-12 h-12 bg-[#2c3e80] text-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Senior Division (Class 11 - 12)</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                @php
                    $seniorCourses = [
                        ['title' => 'Pioneers', 'class' => 'Class XI', 'desc' => 'Lead the way with in-depth preparation for Class XI and competitive exams.', 'fee' => '45,600', 'inst' => ['18,240', '18,240', '9,120']],
                        ['title' => 'Gurus', 'class' => 'Class XII', 'desc' => 'Master your subjects with advanced learning strategies for board success.', 'fee' => '45,600', 'inst' => ['18,240', '18,240', '9,120']],
                    ];
                @endphp

                @foreach($seniorCourses as $course)
                <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-10 flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="mb-6">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#2c3e80]/60 mb-2 block">{{ $course['class'] }}</span>
                        <h3 class="text-3xl font-bold text-gray-800 mb-4">{{ $course['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed">{{ $course['desc'] }}</p>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="bg-gray-50 rounded-2xl p-8 group-hover:bg-[#2c3e80]/5 transition-colors duration-300">
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-gray-400 text-sm font-bold">Total Fee: ₹</span>
                                <span class="text-4xl font-black text-[#2c3e80]">{{ $course['fee'] }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                                @foreach($course['inst'] as $index => $amt)
                                <div>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Inst. {{ $index + 1 }}</p>
                                    <p class="text-sm font-bold text-gray-800">₹{{ $amt }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Fee Terms -->
        <div class="bg-gray-50 rounded-xl p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Fee Terms & Conditions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">
                <div>
                    <p class="font-bold mb-2">One-Time Payment Discount:</p>
                    <p class="text-lg text-[#2c3e80] font-bold">₹4,000 for Class XI/XII</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Registration Fee:</p>
                    <p class="text-lg text-[#2c3e80] font-bold">₹500</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Fee Submission Schedule:</p>
                    <p>Gap of 60 days between 1st and 2nd installments, and 45 days between 2nd and 3rd installments.</p>
                </div>
                <div>
                    <p class="font-bold mb-2">Late Fee Penalty:</p>
                    <p>₹50 per day</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-6 py-12 bg-gray-50">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Best Coaching for Class 6-12 near Kakarmatta, Varanasi
    </h2>
    <p class="text-gray-600 mb-4">
        Whether your child is in Class 6 building their foundation 
        or in Class 12 preparing for IIT JEE and NEET, Optimal 
        Classes near DLW Colony Varanasi has the right program 
        with experienced faculty and proven results.
    </p>
    <p class="text-gray-600">
        Our fee structure is designed to be affordable with easy 
        installments, making quality education accessible to all 
        students in Kakarmatta, BLW, Sunderpur and surrounding areas.
    </p>
</div>
@endsection