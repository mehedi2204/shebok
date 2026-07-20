@extends('layouts.app')

@section('content')
<div class="bg-[#F8FAFC] py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-16 sm:mb-20">
            <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">{!! __('messages.choose_package') !!}</h2>
            <p class="text-slate-500 text-lg font-medium leading-relaxed">{{ __('messages.package_subtitle') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 max-w-7xl mx-auto">
            @forelse($packages as $package)
            @php $isPopular = $loop->index == 1; @endphp
            <div class="bg-{{ $isPopular ? 'slate-900' : 'white' }} rounded-[2.5rem] p-8 sm:p-10 border border-{{ $isPopular ? 'slate-800' : 'slate-100' }} shadow-{{ $isPopular ? '2xl' : 'xl' }} {{ $isPopular ? 'shadow-blue-200/50 scale-105 z-10' : 'shadow-slate-200/40 hover:scale-[1.02]' }} transition-all duration-300 relative overflow-hidden flex flex-col">
                @if($isPopular)
                    <div class="absolute top-0 right-0 bg-blue-600 text-white px-8 py-3 rounded-bl-3xl text-xs font-black uppercase tracking-widest">{{ __('messages.most_popular') }}</div>
                @endif

                <div class="mb-10">
                    <h3 class="text-2xl font-bold {{ $isPopular ? 'text-white' : 'text-slate-800' }} mb-2">{{ $package->name }}</h3>
                    <p class="text-slate-400 font-medium">{{ __('messages.plan_duration', ['days' => $package->duration_days]) }}</p>
                </div>
                <div class="mb-10">
                    <div class="flex items-baseline {{ $isPopular ? 'text-white' : '' }}">
                        <span class="text-5xl font-extrabold">৳{{ number_format($package->price) }}</span>
                    </div>
                </div>
                <ul class="space-y-5 mb-12 flex-grow">
                    @if($package->features)
                        @foreach($package->features as $feature)
                        <li class="flex items-center space-x-4">
                            <div class="bg-{{ $isPopular ? 'blue-500' : 'green-100' }} p-1 rounded-full">
                                <svg class="w-4 h-4 {{ $isPopular ? 'text-white' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="{{ $isPopular ? 'text-slate-200' : 'text-slate-600' }} font-bold">{{ $feature }}</span>
                        </li>
                        @endforeach
                    @endif
                </ul>
                <a href="{{ auth()->check() ? '/user/dashboard' : '/login' }}" class="w-full py-5 text-center {{ $isPopular ? 'bg-blue-600 text-white hover:bg-blue-500' : 'bg-slate-100 text-slate-800 hover:bg-slate-200' }} rounded-2xl font-extrabold transition active:scale-95">
                    {{ auth()->check() ? __('messages.upgrade_now') : __('messages.get_started') }}
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 bg-white rounded-[3rem] border border-slate-100 shadow-sm">
                <p class="text-slate-400 font-bold italic">{{ __('messages.no_packages') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
