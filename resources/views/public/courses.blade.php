@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container mx-auto px-6 py-20">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-4">Courses & Fee Structure</h1>
        <p class="text-lg text-gray-600 text-center mb-12">Session 2026-27</p>

        <!-- Classes 6-10 -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Classes 6 - 10</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!-- Pre-Foundation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Pre-Foundation</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class VI</p>
                    <p class="text-gray-600 mb-6">Build a strong Pre-foundation with our tailored program for Class VI students.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 22,200</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 4,440</span></p>
                        </div>
                    </div>
                </div>

                <!-- Foundation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Foundation</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class VII</p>
                    <p class="text-gray-600 mb-6">Build a strong foundation with our tailored program for Class VII students.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 22,200</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 4,440</span></p>
                        </div>
                    </div>
                </div>

                <!-- Spark -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Spark</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class VIII</p>
                    <p class="text-gray-600 mb-6">Ignite the spark of learning with our advanced curriculum for Class VIII.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 22,200</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 8,880</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 4,440</span></p>
                        </div>
                    </div>
                </div>

                <!-- Maverick -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Maverick</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class IX</p>
                    <p class="text-gray-600 mb-6">Empower young minds to excel in Class IX with comprehensive learning experience.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 30,000</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 12,000</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 12,000</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 6,000</span></p>
                        </div>
                    </div>
                </div>

                <!-- Ace -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Ace</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class X</p>
                    <p class="text-gray-600 mb-6">Achieve excellence and ace your Class X exams with expert guidance.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 30,000</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 12,000</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 12,000</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 6,000</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes 11-12 -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Classes 11 - 12</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <!-- Pioneers -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Pioneers</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class XI</p>
                    <p class="text-gray-600 mb-6">Lead the way with in-depth preparation for Class XI and beyond.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 45,600</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 18,240</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 18,240</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 9,120</span></p>
                        </div>
                    </div>
                </div>

                <!-- Gurus -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-[#2c3e80] mb-2">Gurus</h3>
                    <p class="text-gray-600 mb-4 text-sm">For Class XII</p>
                    <p class="text-gray-600 mb-6">Master your subjects with advanced learning strategies for Class XII.</p>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <p class="text-gray-700 font-bold text-lg mb-3">₹ 45,600</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p>1st Installment: <span class="font-bold">₹ 18,240</span></p>
                            <p>2nd Installment: <span class="font-bold">₹ 18,240</span></p>
                            <p>3rd Installment: <span class="font-bold">₹ 9,120</span></p>
                        </div>
                    </div>
                </div>
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
@endsection