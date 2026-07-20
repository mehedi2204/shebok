<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $globalSettings['website_name'] ?? 'Shebok' }} | Premium Medical Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js for Mobile Menu -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-900 overflow-x-hidden" x-data="{ mobileMenuOpen: false }">
    <header class="fixed top-0 left-0 right-0 z-[100] transition-all duration-300">
        <nav class="container mx-auto px-4 sm:px-6 py-4">
            <div class="glass rounded-2xl px-4 sm:px-6 py-3 flex items-center justify-between shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <a href="/" class="flex items-center space-x-2 sm:space-x-3 group">
                    <div class="bg-blue-600 p-2 rounded-xl group-hover:rotate-12 transition-transform duration-300 shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-xl sm:text-2xl font-extrabold text-slate-800 tracking-tight">{{ $globalSettings['website_name'] ?? 'Shebok' }}<span class="text-blue-600">.</span></span>
                </a>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex space-x-8 items-center">
                    <a href="/" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.home') }}</a>
                    <a href="/services" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.find_service') }}</a>
                    @auth
                        <a href="{{ route('chat.index') }}" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.conversations') }}</a>
                    @endauth
                    @if(($globalSettings['payment_required'] ?? '1') == '1')
                    <a href="/packages" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.pricing') }}</a>
                    @endif
                    <a href="/about-us" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.about_us') }}</a>
                    <a href="/contact-us" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.contact') }}</a>

                    <div class="h-6 w-[1px] bg-slate-200 mx-2"></div>

                    <div class="flex items-center space-x-1 bg-slate-100 p-1 rounded-xl">
                        <a href="/lang/en" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() == 'en' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">EN</a>
                        <a href="/lang/bn" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ app()->getLocale() == 'bn' ? 'bg-white shadow-sm text-blue-600' : 'text-slate-500 hover:text-slate-700' }}">BN</a>
                    </div>

                    @auth
                        <div class="flex items-center space-x-6">
                            @if(Auth::user()->role === 'admin')
                                <a href="/admin/dashboard" class="text-slate-600 hover:text-blue-600 font-semibold transition-colors">{{ __('messages.admin_panel') }}</a>
                            @else
                                <a href="/user/dashboard" class="flex items-center space-x-3 group">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 transition-all">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-9 h-9 rounded-xl object-cover ring-2 ring-slate-100 group-hover:ring-blue-100 transition-all">
                                    @endif
                                    <span class="text-slate-600 group-hover:text-blue-600 font-semibold transition-colors">{{ __('messages.dashboard') }}</span>
                                </a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-slate-900 text-white px-7 py-2.5 rounded-xl font-bold hover:bg-slate-800 transition shadow-xl shadow-slate-200 active:scale-95">{{ __('messages.logout') }}</button>
                            </form>
                        </div>
                    @else
                        <a href="/login" class="bg-slate-900 text-white px-7 py-2.5 rounded-xl font-bold hover:bg-slate-800 transition shadow-xl shadow-slate-200 active:scale-95">{{ __('messages.login') }}</a>
                    @endauth
                </div>

                <!-- Mobile Header Actions -->
                <div class="flex items-center space-x-4 lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 bg-slate-50 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="lg:hidden absolute top-24 left-0 right-0 px-4 z-50" x-cloak>
            <div class="glass rounded-[2rem] p-6 shadow-2xl space-y-4">
                <a href="/" class="block px-6 py-4 rounded-2xl bg-blue-50 text-blue-600 font-bold">{{ __('messages.home') }}</a>
                <a href="/services" class="block px-6 py-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.find_service') }}</a>
                @auth
                    <a href="{{ route('chat.index') }}" class="block px-6 py-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.conversations') }}</a>
                @endauth
                @if(($globalSettings['payment_required'] ?? '1') == '1')
                <a href="/packages" class="block px-6 py-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.pricing') }}</a>
                @endif
                <a href="/about-us" class="block px-6 py-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.about_us') }}</a>
                <a href="/contact-us" class="block px-6 py-4 rounded-2xl text-slate-600 font-bold hover:bg-slate-50">{{ __('messages.contact') }}</a>
                <div class="pt-4 border-t border-slate-100">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="/admin/dashboard" class="block w-full py-4 text-slate-600 font-bold text-center">{{ __('messages.admin_panel') }}</a>
                        @else
                            <div class="flex items-center justify-center space-x-3 py-4">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-xl object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="w-10 h-10 rounded-xl object-cover">
                                @endif
                                <a href="/user/dashboard" class="text-slate-600 font-bold">{{ __('messages.dashboard') }}</a>
                            </div>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-center mt-2">{{ __('messages.logout') }}</button>
                        </form>
                    @else
                        <a href="/login" class="block w-full py-4 bg-slate-900 text-white rounded-2xl font-bold text-center">{{ __('messages.login') }}</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="pt-20 sm:pt-24">
        @if(session('success'))
            <div class="container mx-auto px-4 mb-6">
                <div class="max-w-4xl mx-auto bg-green-50 border border-green-100 text-green-600 px-6 py-4 rounded-2xl font-bold text-sm text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="container mx-auto px-4 mb-6">
                <div class="max-w-4xl mx-auto bg-red-50 border border-red-100 text-red-600 px-6 py-4 rounded-2xl font-bold text-sm text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-white pt-16 sm:pt-20 pb-10 border-t border-slate-100 mt-20">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-12 mb-16">
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-blue-600 p-2 rounded-xl">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <span class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $globalSettings['website_name'] ?? 'Shebok' }}<span class="text-blue-600">.</span></span>
                    </div>
                    <p class="text-slate-500 leading-relaxed font-medium">{{ __('messages.footer_tagline') }}</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase tracking-wider text-sm">{{ __('messages.navigation') }}</h4>
                    <ul class="space-y-4 text-slate-500 font-medium text-sm">
                        <li><a href="/services" class="hover:text-blue-600 transition-colors">{{ __('messages.find_service') }}</a></li>
                        <li><a href="/help-center" class="hover:text-blue-600 transition-colors">{{ __('messages.help_center') }}</a></li>
                        <li><a href="/contact-us" class="hover:text-blue-600 transition-colors">{{ __('messages.contact_us') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase tracking-wider text-sm">{{ __('messages.company') }}</h4>
                    <ul class="space-y-4 text-slate-500 font-medium text-sm">
                        <li><a href="/about-us" class="hover:text-blue-600 transition-colors">{{ __('messages.about_us') }}</a></li>
                        <li><a href="/terms-of-service" class="hover:text-blue-600 transition-colors">{{ __('messages.terms_of_use') }}</a></li>
                        <li><a href="/privacy-policy" class="hover:text-blue-600 transition-colors">{{ __('messages.privacy_policy') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6 uppercase tracking-wider text-sm">{{ __('messages.support') }}</h4>
                    <p class="text-slate-500 font-medium mb-4 text-sm">{{ $globalSettings['support_email'] ?? 'support@shebok.com' }}</p>
                    <p class="text-slate-800 font-bold text-lg">{{ $globalSettings['contact_number'] ?? '+880 1700 000 000' }}</p>
                    @if($globalSettings['whatsapp_number'] ?? false)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $globalSettings['whatsapp_number']) }}" target="_blank" class="mt-4 flex items-center space-x-2 text-green-600 hover:text-green-700 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884 0 2.225.569 3.946 1.694 5.618l-.998 3.645 3.793-.962zm11.367-7.643c-.307-.154-1.817-.897-2.097-1.0s-.484-.154-.688.154-.788 1-1.031 1.282-.484.308-.791.154c-.307-.154-1.295-.477-2.467-1.521-.911-.813-1.526-1.817-1.705-2.124s-.02-.474.135-.627c.14-.139.307-.359.461-.538.154-.18.205-.308.307-.513s.051-.385-.026-.538c-.077-.154-.688-1.659-.942-2.27s-.501-.513-.688-.513-.384-.015-.59-.015-.538.081-.82.385c-.282.308-1.077 1.051-1.077 2.564s1.103 2.974 1.256 3.179c.154.205 2.174 3.321 5.267 4.659.736.317 1.311.507 1.758.65.74.235 1.414.201 1.946.122.593-.088 1.817-.743 2.074-1.461s.256-1.333.179-1.461-.282-.205-.59-.359z"/></svg>
                        <span class="font-bold text-sm">{{ __('messages.whatsapp_support') }}</span>
                    </a>
                    @endif
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center text-slate-400 text-xs sm:text-sm font-medium gap-4">
                <p class="text-center md:text-left">&copy; {{ date('Y') }} {{ $globalSettings['website_name'] ?? 'Shebok' }} Medical Platform. {{ __('messages.all_rights_reserved') }}</p>
                <div class="flex space-x-6">
                    @if($globalSettings['facebook_url'] ?? false) <a href="{{ $globalSettings['facebook_url'] }}" class="hover:text-blue-600">Facebook</a> @endif
                    @if($globalSettings['linkedin_url'] ?? false) <a href="{{ $globalSettings['linkedin_url'] }}" class="hover:text-blue-600">LinkedIn</a> @endif
                    @if($globalSettings['instagram_url'] ?? false) <a href="{{ $globalSettings['instagram_url'] }}" class="hover:text-blue-600">Instagram</a> @endif
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
