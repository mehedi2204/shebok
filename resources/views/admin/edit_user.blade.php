@extends('layouts.admin')

@section('title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center space-x-4 mb-8">
        <a href="{{ route('admin.users') }}" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100 text-slate-400 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Modify Member Account</h2>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-50">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-3 ml-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-7 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-600/10 font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-3 ml-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-7 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-600/10 font-bold text-slate-800">
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-3 ml-2">User Role</label>
                    <select name="role" class="w-full px-7 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-600/10 font-bold text-slate-800 appearance-none shadow-inner">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Standard User (Seeker/Giver)</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                </div>

                <hr class="border-slate-50 my-10">

                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] mb-1 ml-2">Reset Password</label>
                    <p class="text-[10px] text-slate-400 font-medium mb-3 ml-2 italic">Leave empty to keep current password</p>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-7 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-600/10 font-bold text-slate-800">
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-extrabold text-lg hover:bg-blue-600 transition shadow-xl active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
