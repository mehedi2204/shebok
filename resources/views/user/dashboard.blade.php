@extends("layouts.app")

@section("content")
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full lg:w-80 shrink-0">
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] p-8 border border-slate-50 sticky top-28">
                <div class="text-center mb-8">
                    <div class="relative inline-block">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-28 h-28 rounded-[2rem] mx-auto mb-4 border-4 border-slate-50 shadow-xl object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=128" class="w-28 h-28 rounded-[2rem] mx-auto mb-4 border-4 border-slate-50 shadow-xl">
                        @endif
                        <div class="absolute -bottom-1 -right-1 bg-green-500 w-6 h-6 rounded-full border-4 border-white shadow-sm" title="Active Account"></div>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $user->name }}</h2>
                    <div class="flex items-center justify-center space-x-2 mt-1">
                        @if($providerProfile && $providerProfile->status === 'approved')
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-extrabold px-3 py-1 rounded-lg tracking-wider uppercase">{{ __('messages.verified_provider') }}</span>
                        @elseif($providerProfile && $providerProfile->status === 'pending')
                            <span class="bg-orange-50 text-orange-600 text-[10px] font-extrabold px-3 py-1 rounded-lg tracking-wider uppercase">{{ __('messages.pending_approval') }}</span>
                        @else
                            <span class="bg-slate-50 text-slate-500 text-[10px] font-extrabold px-3 py-1 rounded-lg tracking-wider uppercase">{{ __('messages.service_seeker') }}</span>
                        @endif
                    </div>
                </div>

                <nav class="space-y-3">
                    <a href="{{ url('/user/dashboard') }}" class="flex items-center justify-between px-6 py-4 {{ request()->is('user/dashboard') ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }} rounded-2xl font-bold transition group">
                        <div class="flex items-center space-x-4">
                            <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>{{ __('messages.overview') }}</span>
                        </div>
                    </a>

                    <a href="{{ route('user.profile') }}" class="flex items-center space-x-4 px-6 py-4 {{ request()->is('user/profile') ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }} rounded-2xl font-bold transition group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>{{ __('messages.profile_settings') }}</span>
                    </a>

                    <a href="{{ route('provider.setup') }}" class="flex items-center space-x-4 px-6 py-4 {{ request()->is('service-giver/setup-profile') ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }} rounded-2xl font-bold transition group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ $providerProfile ? __('messages.service_giver_panel') : __('messages.apply_as_provider') }}</span>
                    </a>

                    <a href="{{ route('chat.index') }}" class="flex items-center justify-between px-6 py-4 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-2xl font-bold transition group">
                        <div class="flex items-center space-x-4">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <span>{{ __('messages.conversations') }}</span>
                        </div>
                        @php $totalUnread = \App\Models\Message::whereHas('conversation', function($q) { $q->where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id()); })->where('user_id', '!=', Auth::id())->where('is_read', false)->count(); @endphp
                        @if($totalUnread > 0)
                            <span class="bg-blue-600 text-white text-[9px] font-black px-2 py-1 rounded-lg">{{ $totalUnread }}</span>
                        @endif
                    </a>
                </nav>

                <div class="mt-8 pt-8 border-t border-slate-50">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-4 px-6 py-4 text-red-500 hover:bg-red-50 rounded-2xl font-bold transition group text-left">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>{{ __('messages.logout') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 space-y-8">
            <!-- Header Info -->
            <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ __('messages.welcome_back', ['name' => $user->name]) }}</h3>
                    @if($providerProfile && $providerProfile->status === 'approved')
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            {{ __('messages.profile_live') }}
                        </p>
                    @elseif($providerProfile && $providerProfile->status === 'pending')
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2 flex items-center">
                            <span class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></span>
                            {{ __('messages.application_reviewed') }}
                        </p>
                    @else
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-2">
                            {{ __('messages.ready_to_help') }}
                            <a href="/service-giver/setup-profile" class="text-blue-600 underline ml-1">{{ __('messages.setup_giver_profile') }}</a>
                        </p>
                    @endif
                </div>
                @if($providerProfile && $providerProfile->status === 'approved')
                <div class="flex gap-3">
                    <a href="/service-provider/{{ $providerProfile->id }}" class="bg-blue-50 text-blue-600 px-6 py-3.5 rounded-2xl font-bold hover:bg-blue-100 transition text-sm">{{ __('messages.preview_public_profile') }}</a>
                </div>
                @endif
            </div>

            @if($providerProfile && $providerProfile->status === 'approved')
            <!-- Giver Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $statsData = [
                        ['label' => __('messages.profile_views'), 'value' => $stats['views'], 'color' => 'blue', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                        ['label' => __('messages.inquiries'), 'value' => $stats['connections'], 'color' => 'green', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['label' => __('messages.reviews'), 'value' => $stats['shortlists'], 'color' => 'purple', 'icon' => 'M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z'],
                        ['label' => __('messages.rating'), 'value' => number_format($stats['rating'], 1), 'color' => 'orange', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z']
                    ];
                @endphp

                @foreach($statsData as $stat)
                <div class="bg-white p-6 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-50">
                    <div class="bg-{{$stat['color']}}-50 w-12 h-12 rounded-2xl flex items-center justify-center text-{{$stat['color']}}-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{$stat['icon']}}"></path></svg>
                    </div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">{{$stat['label']}}</p>
                    <p class="text-2xl font-extrabold text-slate-800 tracking-tighter">{{$stat['value']}}</p>
                </div>
                @endforeach
            </div>
            @endif

            @if(!$providerProfile)
            <!-- Promotion to become a giver -->
            <div class="bg-blue-600 p-10 rounded-[2.5rem] shadow-xl shadow-blue-200 text-white relative overflow-hidden">
                <div class="relative z-10 max-w-lg">
                    <h4 class="text-3xl font-extrabold mb-4">{{ __('messages.want_to_provide_services') }}</h4>
                    <p class="text-blue-100 font-medium mb-8">{{ __('messages.join_community_professionals') }}</p>
                    <a href="/service-giver/setup-profile" class="inline-block bg-white text-blue-600 px-10 py-4 rounded-2xl font-extrabold hover:bg-slate-50 transition shadow-lg active:scale-95">{{ __('messages.apply_as_provider') }}</a>
                </div>
                <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full -mr-20 -mb-20"></div>
            </div>
            @endif

            <!-- Saved Profiles (Seeker Activity) -->
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-50 overflow-hidden">
                <div class="p-8 border-b border-slate-50">
                    <h4 class="text-xl font-extrabold text-slate-800 tracking-tight">{{ __('messages.saved_service_givers') }}</h4>
                    <p class="text-slate-400 text-[10px] font-extrabold uppercase tracking-widest mt-1">{{ __('messages.shortlisted_professionals') }}</p>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($savedProfiles as $saved)
                    <div class="flex items-center justify-between p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 group">
                        <div class="flex items-center space-x-4">
                            @if($saved->providerProfile->user->avatar)
                                <img src="{{ asset('storage/' . $saved->providerProfile->user->avatar) }}" class="w-12 h-12 rounded-xl object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($saved->providerProfile->user->name) }}&background=random" class="w-12 h-12 rounded-xl">
                            @endif
                            <div>
                                <h5 class="font-extrabold text-slate-800 tracking-tight">{{ $saved->providerProfile->user->name }}</h5>
                                <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-widest">{{ $saved->providerProfile->category->name }}</p>
                            </div>
                        </div>
                        <a href="/service-provider/{{ $saved->provider_profile_id }}" class="p-2.5 text-blue-600 hover:bg-blue-100 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </div>
                    @empty
                    <div class="col-span-2 text-center py-10">
                        <p class="text-slate-400 font-bold italic">{{ __('messages.no_saved_profiles') }}</p>
                        <a href="/services" class="text-blue-600 text-xs font-black uppercase tracking-widest mt-4 inline-block hover:underline">{{ __('messages.find_services') }}</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
