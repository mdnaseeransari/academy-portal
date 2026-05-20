@extends('layouts.public')
@section('title', 'Contact Optimal Classes | Coaching near Kakarmatta & DLW Varanasi')
@section('meta_description', 'Contact Optimal Classes at New Colony Kakarmatta, Varanasi. Call +91 9415228666. Best coaching near DLW Colony for Class 6-12, IIT-JEE and NEET.')
@section('meta_keywords', 'contact optimal classes varanasi, coaching near kakarmatta contact, DLW varanasi coaching enquiry')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <!-- Contact Form Section -->
        <div class="max-w-2xl mx-auto mb-16">
            <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Any Enquiry?</h1>
            <p class="text-lg text-gray-600 text-center mb-12">Get in touch with us. We're here to help!</p>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-gray-700 mb-2">First Name *</label>
                        <input type="text" name="first_name" id="first_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2c3e80] outline-none">
                        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-gray-700 mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2c3e80] outline-none">
                        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email Address *</label>
                    <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2c3e80] outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Phone Number *</label>
                    <input type="tel" name="phone" id="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2c3e80] outline-none" placeholder="+91">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Message *</label>
                    <textarea name="message" id="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2c3e80] outline-none"></textarea>
                    @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-[#2c3e80] text-white font-bold py-3 rounded-lg hover:bg-[#1e2d5e] transition">Send Message</button>
            </form>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q1. What subjects do you teach at Optimal Classes?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">We offer coaching in all major subjects including Physics, Chemistry, Biology, and Mathematics for CBSE, ICSE, and ISC students from Classes 8–12.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q2. Do you provide IIT JEE and NEET preparation?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">Yes. We are a leading IIT JEE and NEET coaching institute in Varanasi with expert faculty, regular tests, and performance tracking.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q3. Are foundation and pre-foundation courses available?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">Absolutely. Our pre-foundation coaching in Varanasi helps younger students strengthen their basics early for future academic challenges.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q4. Which locations do you serve?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">We serve students across BLW, Kakarmatta, Sunderpur, Lanka, Manduadih, Chitaipur, Cantt, Lahartara, Durgakund, and nearby areas.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q5. Why choose Optimal Classes over other institutes?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">Our unique combination of experienced teachers, personalized attention, quality study materials, and consistent results makes us the best coaching institute in Varanasi.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q6. Where exactly is Optimal Classes located?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">Near Indrani Gas Agency, New Colony Kakarmatta, Varanasi — just 5 minutes from DLW gate and 10 minutes from BLW Colony.</p>
                </details>

                <details class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 cursor-pointer group">
                    <summary class="flex items-center justify-between font-bold text-gray-800 text-lg">
                        Q7. How do I get admission at Optimal Classes?
                        <span class="transition group-open:rotate-180">▼</span>
                    </summary>
                    <p class="text-gray-600 mt-4">Simply call +91 9415228666 or fill the enquiry form above. Walk-in visits are welcome at our Kakarmatta centre during working hours (9 AM to 8 PM).</p>
                </details>
            </div>
        </div>
    </div>
</div>
@endsection