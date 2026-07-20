@extends('layouts.app')

@section('content')
<!-- Search Header -->
<section class="bg-slate-900 pt-10 sm:pt-16 pb-32 sm:pb-48 -mt-8 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500 rounded-full blur-[120px] translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-purple-500 rounded-full blur-[120px] -translate-x-1/3 translate-y-1/3"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">Find Your Service Provider</h1>
            <p class="text-slate-400 text-base sm:text-lg mb-10 max-w-2xl mx-auto leading-relaxed">Search by service, area, or provider name to find the best match for your needs.</p>

            <!-- Search Bar Container -->
            <form action="{{ url('/services') }}" method="GET" class="bg-white/5 backdrop-blur-xl p-3 sm:p-4 rounded-[2.5rem] border border-white/10 shadow-[0_25px_50px_-12px_rgba(0,0,0,0.5)]">
                <div class="flex flex-col lg:flex-row gap-3 sm:gap-4">
                    <div class="flex-1 relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-blue-500 group-focus-within:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <select name="category" class="w-full pl-14 pr-6 py-4 sm:py-5 bg-white rounded-[1.5rem] border-none focus:ring-4 focus:ring-blue-500/30 text-slate-800 font-semibold shadow-inner appearance-none text-sm sm:text-base">
                            <option value="">All Services</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 relative group">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-blue-500 group-focus-within:text-blue-400 transition-colors">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <input type="text" name="location" value="{{ request('location') }}" placeholder="In which area?" class="w-full pl-14 pr-6 py-4 sm:py-5 bg-white rounded-[1.5rem] border-none focus:ring-4 focus:ring-blue-500/30 text-slate-800 font-semibold shadow-inner placeholder:text-slate-400 text-sm sm:text-base">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-10 py-4 sm:py-5 rounded-[1.5rem] font-extrabold hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/20 active:scale-95 text-sm sm:text-base whitespace-nowrap lg:min-w-[180px]">
                        Search Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Provider Profiles -->
<section class="container mx-auto px-4 sm:px-6 -mt-20 sm:-mt-24 pb-24 relative z-20">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($providers as $provider)
        <div class="group bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-50 overflow-hidden hover:shadow-[0_40px_80px_rgba(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
            <div class="p-6 sm:p-8 flex flex-col h-full">
                <div class="flex items-center space-x-4 sm:space-x-6 mb-6">
                    @if($provider->user->avatar)
                        <img src="{{ asset('storage/' . $provider->user->avatar) }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover shadow-lg group-hover:scale-105 transition-transform shrink-0">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($provider->user->name) }}&background=random" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover shadow-lg group-hover:scale-105 transition-transform shrink-0">
                    @endif
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 truncate">{{ $provider->user->name }}</h3>
                        <p class="text-blue-600 font-bold text-[10px] sm:text-xs uppercase tracking-wider truncate">{{ $provider->profession }}</p>
                    </div>
                </div>

                <div class="flex items-center text-slate-400 font-bold text-[10px] sm:text-xs mb-6 space-x-2 uppercase tracking-[0.1em]">
                    <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="truncate">{{ $provider->location }}</span>
                </div>

                <div class="bg-slate-50 rounded-2xl p-4 mb-6 mt-auto">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-bold text-[10px] uppercase tracking-widest">Rate</span>
                        <span class="text-lg sm:text-xl font-extrabold text-slate-900 whitespace-nowrap">৳{{ number_format($provider->price_per_hour) }} <small class="text-[10px] text-slate-400 font-bold">/{{ ucfirst($provider->rate_type) }}</small></span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ url('/service-provider/'.$provider->id) }}" class="flex-1 bg-slate-900 text-white text-center py-3.5 sm:py-4 rounded-2xl font-bold hover:bg-blue-600 transition shadow-lg active:scale-95 text-xs sm:text-sm">
                        View Profile
                    </a>
                    <a href="{{ route('chat.start', $provider->user_id) }}" class="p-3.5 sm:p-4 bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-100 transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-white rounded-[3rem] shadow-sm border border-slate-50">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 mb-2">No providers found</h3>
            <p class="text-slate-400 font-medium">Try adjusting your search filters to find what you're looking for.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-12">
        {{ $providers->links() }}
    </div>
</section>
@endsection
