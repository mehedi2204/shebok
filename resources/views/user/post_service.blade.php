@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12" x-data="{ step: 1, category: '' }">
    <div class="max-w-3xl mx-auto">
        <!-- Progress Steps -->
        <div class="flex items-center justify-between mb-16 relative">
            <div class="absolute top-1/2 left-0 right-0 h-[2px] bg-slate-100 -z-10"></div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center font-black transition-all duration-500 border-4"
                 :class="step >= 1 ? 'bg-blue-600 text-white border-blue-100 shadow-xl' : 'bg-white text-slate-300 border-slate-50'">1</div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center font-black transition-all duration-500 border-4"
                 :class="step >= 2 ? 'bg-blue-600 text-white border-blue-100 shadow-xl' : 'bg-white text-slate-300 border-slate-50'">2</div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center font-black transition-all duration-500 border-4"
                 :class="step >= 3 ? 'bg-blue-600 text-white border-blue-100 shadow-xl' : 'bg-white text-slate-300 border-slate-50'">3</div>
        </div>

        <!-- Step 1: Select Type & Category -->
        <div x-show="step == 1" class="space-y-8 animate-fade-in">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-slate-900 mb-4">Start your posting</h1>
                <p class="text-slate-500 font-medium">First, tell us what you are looking for.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <button @click="category = 'Need Service'; step = 2" class="p-10 bg-white rounded-[2.5rem] shadow-xl border border-slate-50 hover:-translate-y-2 transition-all duration-500 group text-left">
                    <div class="bg-purple-50 w-16 h-16 rounded-2xl flex items-center justify-center text-purple-600 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">I Need Service</h3>
                    <p class="text-slate-500 font-medium">Post a request to find qualified medical help.</p>
                </button>

                <button @click="category = 'Give Service'; step = 2" class="p-10 bg-white rounded-[2.5rem] shadow-xl border border-slate-50 hover:-translate-y-2 transition-all duration-500 group text-left">
                    <div class="bg-blue-50 w-16 h-16 rounded-2xl flex items-center justify-center text-blue-600 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">I Give Service</h3>
                    <p class="text-slate-500 font-medium">Share your qualifications and offer help.</p>
                </button>
            </div>
        </div>

        <!-- Step 2: Form Details (Dynamic simulation) -->
        <div x-show="step == 2" class="bg-white p-10 sm:p-16 rounded-[3rem] shadow-2xl border border-slate-50 space-y-10 animate-fade-in" x-cloak>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Complete the details</h2>
                <p class="text-slate-500 font-medium mt-2">Fields marked with <span class="text-red-500">*</span> are required.</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3">Service Category <span class="text-red-500">*</span></label>
                    <select class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20">
                        <option>Home Nursing</option>
                        <option>Physiotherapy</option>
                        <option>Elderly Care</option>
                    </select>
                </div>

                <!-- Simulation of fields built by Admin -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3">Title of your post <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="e.g. ICU Nurse for Home" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20">
                    </div>
                    <div>
                        <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3">Price (৳) <span class="text-red-500">*</span></label>
                        <input type="number" placeholder="1500" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3">Description <span class="text-red-500">*</span></label>
                    <textarea rows="4" placeholder="Detailed requirements or qualifications..." class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20"></textarea>
                </div>

                <!-- Admin Dynamic Fields simulation -->
                <div class="p-8 bg-blue-50/50 rounded-[2rem] border border-blue-100/50 space-y-6">
                    <p class="text-blue-600 font-black text-xs uppercase tracking-widest">Category Specific Requirements</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-500 font-bold text-xs mb-2">Educational Qualification</label>
                            <input type="text" class="w-full px-6 py-3 bg-white border-none rounded-xl font-semibold shadow-sm">
                        </div>
                        <div>
                            <label class="block text-slate-500 font-bold text-xs mb-2">Years of Experience</label>
                            <input type="number" class="w-full px-6 py-3 bg-white border-none rounded-xl font-semibold shadow-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-8">
                <button @click="step = 1" class="text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-900 transition">Go Back</button>
                <button @click="step = 3" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 active:scale-95">Publish Post</button>
            </div>
        </div>

        <!-- Step 3: Success -->
        <div x-show="step == 3" class="text-center space-y-8 animate-fade-in" x-cloak>
            <div class="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center text-green-600 mx-auto mb-10 shadow-xl shadow-green-100">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-4xl font-extrabold text-slate-900 tracking-tight">Your post is live!</h2>
            <p class="text-slate-500 font-medium max-w-sm mx-auto">People can now see your listing and connect with you directly via chat.</p>
            <div class="pt-8">
                <a href="/user/dashboard" class="bg-slate-900 text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-blue-600 transition shadow-2xl active:scale-95 inline-block">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
