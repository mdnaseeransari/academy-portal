@extends('layouts.public')

@section('content')
<!-- About Us Page Content -->
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <!-- Director Section -->
        <div class="mb-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Our Director</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Shobhit Kumar Srivastava</h3>
                    <p class="text-[#2c3e80] font-medium mb-6">Director, B.Tech from H.B.T.I Kanpur (Mechanical Engineering)</p>
                    <p class="text-gray-600 leading-relaxed mb-6">Shobhit Kumar Srivastava, the esteemed director of Optimal Classes, is a visionary leader dedicated to transforming the field of education. He earned his B. Tech. degree in 2007 from H. B. T. I. Kanpur, one of India's most prestigious engineering colleges. Before embarking on his journey as an educator, Mr. Srivastava built a remarkable career as a senior engineer at Larsen & Toubro (L&T) and Hindustan Construction Company (HCC) from 2007 to 2017. Driven by a profound desire to serve the nation, he transitioned to education in 2017 and has been passionately committed to nurturing young minds ever since.</p>
                    <p class="text-gray-500 italic">Warm regards, Shobhit Kumar Srivastava, Director</p>
                </div>
                <div class="bg-gray-200 h-80 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 text-lg">Director Photo</span>
                </div>
            </div>
        </div>

        <!-- Vision and Mission -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="bg-[#2c3e80] text-white p-8 rounded-xl">
                <h3 class="text-2xl font-bold mb-4">Our Vision</h3>
                <p class="text-white/90 leading-relaxed">To empower students through high-quality digital education, fostering easy understanding with the guidance of highly qualified and experienced tutors.</p>
            </div>
            <div class="bg-white border-2 border-[#2c3e80] p-8 rounded-xl">
                <h3 class="text-2xl font-bold text-[#2c3e80] mb-4">Our Mission</h3>
                <p class="text-gray-700 leading-relaxed">To be a leading provider of innovative digital education that transforms learning into an engaging, accessible, and effective journey.</p>
            </div>
        </div>

        <!-- Academic Team -->
        <div class="mb-20">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Our Academic Team</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">SS</div>
                    <h4 class="font-bold text-gray-800 text-sm">Shobhit Srivastava</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">Maths</span>
                    <p class="text-xs text-gray-500 mt-1">B.Tech HBTI Kanpur, 7+ years</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">RP</div>
                    <h4 class="font-bold text-gray-800 text-sm">Rahul Pandey</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">Physics</span>
                    <p class="text-xs text-gray-500 mt-1">M.Sc. Physics, 10+ years</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">VS</div>
                    <h4 class="font-bold text-gray-800 text-sm">Vaibhav Singh</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">Chemistry</span>
                    <p class="text-xs text-gray-500 mt-1">M.Sc. Chemistry, 6+ years</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">MS</div>
                    <h4 class="font-bold text-gray-800 text-sm">Ms. Shalini</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">English</span>
                    <p class="text-xs text-gray-500 mt-1">Masters from BHU, 2+ years</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">SA</div>
                    <h4 class="font-bold text-gray-800 text-sm">Sahil Ali</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">Science</span>
                    <p class="text-xs text-gray-500 mt-1">B.Tech, 4+ years</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-[#2c3e80] text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">AY</div>
                    <h4 class="font-bold text-gray-800 text-sm">Anuj Yadav</h4>
                    <span class="bg-[#2c3e80] text-white text-xs px-2 py-1 rounded">Biology</span>
                    <p class="text-xs text-gray-500 mt-1">M.Sc. Botany, 5+ years</p>
                </div>
            </div>
        </div>

        <!-- Student's Journey -->
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">Student's Journey Inside Optimal Classes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">📱 Digital Classrooms</h4>
                    <p class="text-gray-600">Our classrooms are equipped with state-of-the-art technology to provide a dynamic and interactive learning experience through multimedia tools.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">💭 Focus on Critical Thinking</h4>
                    <p class="text-gray-600">We emphasize conceptual understanding and critical thinking skills to prepare students for academic and real-world challenges.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">⚖️ Balanced Preparation</h4>
                    <p class="text-gray-600">Our curriculum is designed to balance board exam preparation with competitive exams like IIT-JEE and NEET, ensuring success in both.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">🏆 Proven Track Record</h4>
                    <p class="text-gray-600">With a proven track record of excellence, our students consistently achieve outstanding results, solidifying our reputation as a trusted leader in education.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">📝 Regular Assessments</h4>
                    <p class="text-gray-600">Weekly tests conducted every Sunday help track student progress, identify areas of improvement, and ensure exam readiness.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">📚 Customized Study Material</h4>
                    <p class="text-gray-600">Our in-house experts create study materials tailored to simplify complex topics while aligning with the latest syllabus.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">✏️ Worksheets for Every Chapter</h4>
                    <p class="text-gray-600">Every chapter is supplemented with worksheets to ensure students thoroughly understand and practice each topic.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-[#2c3e80] mb-3">❓ Doubt Clarification Sessions</h4>
                    <p class="text-gray-600">Dedicated sessions address individual queries, ensuring no student is left behind and all doubts are clarified.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection