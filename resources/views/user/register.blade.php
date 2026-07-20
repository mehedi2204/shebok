@extends('layouts.app')

@section('content')
<div class="min-h-[90vh] flex items-center justify-center px-4 sm:px-6 py-12">
    <div class="max-w-xl w-full">
        <!-- Card -->
        <div class="bg-white p-8 sm:p-12 rounded-[2.5rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-blue-50 rounded-bl-[120px] -mr-16 -mt-16 opacity-50"></div>

            <div class="relative z-10">
                <div class="mb-10 text-center sm:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">Join Shebok</h2>
                    <p class="text-slate-500 font-medium italic">Create an account to start your journey with us.</p>
                </div>

                <form class="space-y-6" action="/register" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Mehedi Hasan" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-300">
                            @error('name') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-300">
                            @error('email') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Password</label>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all">
                            @error('password') <p class="text-red-500 text-[10px] mt-1 ml-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-bold text-lg hover:bg-blue-600 transition shadow-xl active:scale-95 flex items-center justify-center space-x-2">
                            <span>Create Account</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                    <p class="text-slate-500 font-medium">
                        Already a member?
                        <a href="/login" class="text-blue-600 font-extrabold hover:underline ml-1">Sign in here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
