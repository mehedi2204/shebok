@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-12">
        <!-- Main Content -->
        <div class="flex-1 space-y-12">
            <!-- Header/Hero details -->
            <div class="bg-white p-10 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-50 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -mr-10 -mt-10"></div>

                <div class="relative z-10">
                    <div class="flex items-center space-x-2 bg-blue-50 text-blue-700 px-4 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-6 w-fit">
                        Verified Service Giver
                    </div>
                    <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 leading-tight mb-6">Expert Post-Surgery Home Nurse</h1>
                    <div class="flex flex-wrap gap-6 items-center text-slate-500 font-bold text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>Dhanmondi, Dhaka</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Available from 8:00 AM - 8:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-6">
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">About this service</h3>
                <p class="text-lg text-slate-600 leading-relaxed font-medium">
                    I am a professional BSc nurse with over 8 years of experience in critical care and post-surgery recovery. I provide compassionate and science-based medical assistance directly at your home. My services include monitoring vital signs, medication administration, wound dressing, and emotional support for the patient.
                </p>

                <!-- Dynamic Fields mockup -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Educational Qualification</p>
                        <p class="text-lg font-extrabold text-slate-800 tracking-tight">BSc in Nursing (DU)</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Experience</p>
                        <p class="text-lg font-extrabold text-slate-800 tracking-tight">8 Years in ICU</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Shift Type</p>
                        <p class="text-lg font-extrabold text-slate-800 tracking-tight">Day / Night Shift</p>
                    </div>
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Certifications</p>
                        <p class="text-lg font-extrabold text-slate-800 tracking-tight text-blue-600 underline">View BLS Certificate</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="w-full lg:w-96 space-y-8">
            <div class="bg-slate-900 p-10 rounded-[2.5rem] shadow-2xl sticky top-32">
                @if(($globalSettings['payment_required'] ?? '1') == '1')
                <div class="mb-8">
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-xs mb-2">Pricing</p>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-5xl font-black text-white tracking-tighter">৳1500</span>
                        <span class="text-slate-400 font-bold text-lg">/ day</span>
                    </div>
                </div>
                @endif

                <div class="space-y-4">
                    <a href="/chat" class="block w-full py-5 bg-blue-600 text-white rounded-2xl text-center font-bold text-lg hover:bg-blue-700 transition shadow-xl shadow-blue-500/20 active:scale-95">Connect via Chat</a>
                    <button class="block w-full py-5 bg-white/10 text-white rounded-2xl text-center font-bold text-lg hover:bg-white/20 transition active:scale-95 border border-white/10">Call for Emergency</button>
                </div>

                <div class="mt-10 pt-8 border-t border-white/10 flex items-center space-x-4">
                    <img src="https://ui-avatars.com/api/?name=Nur+Alam&background=random" class="w-14 h-14 rounded-2xl shadow-lg">
                    <div>
                        <p class="text-white font-extrabold text-lg leading-none mb-1">Nur Alam</p>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Joined Jan 2024</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
