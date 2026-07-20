@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="container mx-auto px-4 sm:px-6 lg:min-h-[calc(100vh-140px)] flex items-center overflow-hidden relative pt-2 sm:pt-4 pb-12 sm:pb-20">
    <div class="flex flex-col lg:flex-row items-center gap-8 sm:gap-12 relative z-10 w-full">
        <div class="flex-1 text-center lg:text-left order-2 lg:order-1">
            <div class="inline-flex items-center space-x-2 bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-[10px] sm:text-xs font-extrabold mb-4 sm:mb-6 animate-bounce">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                </span>
                <span class="uppercase tracking-wider">{{ __('messages.trusted_by', ['count' => number_format(5000 + $totalProviders)]) }}</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-slate-900 leading-[1.1] mb-4 sm:mb-6 tracking-tight">
                {{ __('messages.hero_title') }}
            </h1>
            <p class="text-sm sm:text-lg text-slate-500 font-medium leading-relaxed mb-6 sm:mb-10 max-w-2xl mx-auto lg:mx-0">
                {{ __('messages.hero_subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-3 sm:gap-5">
                <a href="/services" class="bg-blue-600 text-white px-8 py-4 sm:py-5 rounded-2xl font-bold text-sm sm:text-lg hover:bg-blue-700 transition shadow-2xl shadow-blue-200 active:scale-95 flex items-center justify-center space-x-2">
                    <span>{{ __('messages.need_service') }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="{{ auth()->check() ? '/user/dashboard' : '/login' }}" class="bg-white text-slate-900 border-2 border-slate-100 px-8 py-4 sm:py-5 rounded-2xl font-bold text-sm sm:text-lg hover:bg-slate-50 transition active:scale-95 flex items-center justify-center">
                    {{ __('messages.i_am_provider') }}
                </a>
            </div>
        </div>

        <!-- Hero Image Area -->
        <div class="flex-1 relative order-1 lg:order-2 w-full max-w-[450px] lg:max-w-[550px] mx-auto lg:mx-0">
            <div class="absolute -top-6 -left-6 w-32 h-32 bg-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
            <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-purple-100 rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>

            <div class="relative bg-white p-2 sm:p-3 rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.1)] border border-slate-100 rotate-1 lg:rotate-2">
                <img class="rounded-[1.5rem] sm:rounded-[2rem] w-full object-cover aspect-[4/3] sm:aspect-square lg:aspect-[4/3]"
                     src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1470&auto=format&fit=crop"
                     alt="Professional Healthcare">

                <!-- Status Badge -->
                <div class="absolute -bottom-4 -left-4 sm:-bottom-6 sm:-left-6 glass p-3 sm:p-5 rounded-2xl sm:rounded-3xl shadow-xl flex items-center space-x-3 -rotate-3 border border-white/50">
                    <div class="bg-green-100 p-2 rounded-xl text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[8px] text-slate-500 font-extrabold uppercase tracking-widest">{{ __('messages.expert_status') }}</p>
                        <p class="text-xs sm:text-base font-extrabold text-slate-800">{{ $totalProviders }} {{ __('messages.verified_givers') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="bg-slate-50/50 py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-center md:items-end mb-12 sm:mb-16 text-center md:text-left gap-6">
            <div class="max-w-xl">
                <span class="text-blue-600 font-extrabold tracking-[0.2em] uppercase text-xs sm:text-sm mb-3 sm:mb-4 block">{{ __('messages.featured_categories') }}</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 leading-tight">{{ __('messages.care_services_tailored') }}</h2>
            </div>
            <a href="/services" class="text-blue-600 font-bold hover:underline flex items-center space-x-2 text-sm sm:text-base group">
                <span>{{ __('messages.see_all') }}</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
            @foreach($categories as $cat)
            @php
                $colors = ['blue', 'purple', 'orange', 'red'];
                $color = $colors[$loop->index % 4];
            @endphp
            <a href="/services?category={{ $cat->slug }}" class="group bg-white p-8 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-50 hover:shadow-[0_40px_80px_rgba(0,0,0,0.06)] hover:-translate-y-2 transition-all duration-500">
                <div class="bg-{{ $color }}-50 w-14 sm:w-16 h-14 sm:h-16 rounded-2xl flex items-center justify-center text-{{ $color }}-600 mb-6 sm:mb-8 group-hover:rotate-6 transition-all duration-500">
                    @if(Str::startsWith($cat->icon, 'storage/'))
                        <img src="{{ asset($cat->icon) }}" class="w-8 h-8 object-contain">
                    @else
                        <span class="text-2xl">{{ $cat->icon }}</span>
                    @endif
                </div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-800 mb-4 group-hover:text-blue-600 transition-colors">{{ $cat->name }}</h3>
                <p class="text-sm sm:text-base text-slate-500 font-medium leading-relaxed mb-6">{{ $cat->tagline ?? __('messages.default_cat_tagline') }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $cat->providers_count }} {{ __('messages.experts') }}</span>
                    <div class="h-1.5 w-12 bg-{{ $color }}-600 rounded-full transition-all duration-500 group-hover:w-1/2"></div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
