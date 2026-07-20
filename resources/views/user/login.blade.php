@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 sm:px-6 py-12">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white p-8 sm:p-12 rounded-[2.5rem] shadow-[0_32px_64px_-15px_rgba(0,0,0,0.05)] border border-slate-50 relative overflow-hidden">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -mr-10 -mt-10 opacity-50"></div>

            <div class="relative z-10">
                <div class="mb-10 text-center sm:text-left">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-3">Welcome back</h2>
                    <p class="text-slate-500 font-medium italic">Log in to manage your medical services and chats.</p>
                </div>

                <form class="space-y-6" action="/login" method="POST">
                    @csrf
                    <div>
                        <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="name@example.com" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-300">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-slate-400 font-extrabold uppercase tracking-widest text-[10px] mb-3 ml-1">Password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-300">
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-blue-600 focus:ring-blue-500/20 transition-all cursor-pointer">
                            <span class="text-sm text-slate-500 font-bold group-hover:text-slate-800 transition-colors">Remember me</span>
                        </label>
                        <a href="#" class="text-sm font-bold text-blue-600 hover:text-blue-700 underline decoration-blue-100 underline-offset-4 transition-all">Forgot?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-bold text-lg hover:bg-blue-600 transition shadow-xl active:scale-95 flex items-center justify-center space-x-2">
                            <span>Sign In</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>

                <div class="mt-10 pt-8 border-t border-slate-50 text-center">
                    <p class="text-slate-500 font-medium">
                        Don't have an account?
                        <a href="/register" class="text-blue-600 font-extrabold hover:underline ml-1">Create one now</a>
                    </p>
                </div>

                <!-- Demo Login Shortcuts -->
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <a href="/user/dashboard" class="py-3 bg-blue-50 text-blue-700 text-center rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-100 transition">User Demo</a>
                    <a href="/admin/dashboard" class="py-3 bg-slate-100 text-slate-700 text-center rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition">Admin Demo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
