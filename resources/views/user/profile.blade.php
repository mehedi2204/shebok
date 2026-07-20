@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-50 overflow-hidden">
            <div class="p-8 sm:p-12 border-b border-slate-50">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Profile Settings</h2>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Manage your personal information</p>
            </div>

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 sm:p-12 space-y-8">
                @csrf
                <div class="flex flex-col items-center mb-10 pb-10 border-b border-slate-50">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden shadow-xl shadow-slate-200 border-4 border-white relative">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" id="avatar_preview" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=random" id="avatar_preview" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer" onclick="document.getElementById('avatar_input').click()">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <input type="file" name="avatar" id="avatar_input" class="hidden" onchange="previewAvatar(this)">
                        <button type="button" onclick="document.getElementById('avatar_input').click()" class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-3 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition active:scale-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-6">Profile Photo</p>
                    @error('avatar') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-bold text-slate-800 transition-all">
                        @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" disabled value="{{ $user->email }}" class="w-full px-6 py-4 bg-slate-100 border-none rounded-2xl font-bold text-slate-400 cursor-not-allowed">
                        <p class="text-[9px] text-slate-400 ml-1 italic">Email cannot be changed.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+880 1xxx-xxxxxx" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-bold text-slate-800 transition-all">
                    @error('phone') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <hr class="border-slate-50">

                <div class="space-y-3">
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Current Password (Required for new password)</label>
                    <input type="password" name="current_password" placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-bold text-slate-800 transition-all">
                    @error('current_password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-bold text-slate-800 transition-all">
                        @error('password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-bold text-slate-800 transition-all">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-4 bg-slate-900 text-white rounded-2xl font-extrabold text-lg hover:bg-blue-600 transition shadow-xl active:scale-95">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="mt-12 bg-red-50/30 rounded-[2.5rem] border border-red-100 overflow-hidden" x-data="{ showDelete: false }">
            <div class="p-8 sm:p-12 border-b border-red-50 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-extrabold text-red-600 tracking-tight">Danger Zone</h3>
                    <p class="text-red-400 font-bold text-[10px] uppercase tracking-widest mt-1">Irreversible actions for your account</p>
                </div>
                <button @click="showDelete = true" class="px-6 py-3 bg-red-600 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-xl shadow-red-200 hover:bg-red-700 transition active:scale-95">Delete Account</button>
            </div>

            <!-- Deletion Form (Hidden by default) -->
            <div x-show="showDelete" x-transition class="p-8 sm:p-12 bg-white border-t border-red-50">
                <form action="{{ route('user.profile.delete') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('DELETE')

                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Reason for leaving</label>
                        <select name="reason" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-red-500/10 font-bold text-slate-800 transition-all appearance-none">
                            <option value="">Select a reason</option>
                            <option value="privacy">Privacy concerns</option>
                            <option value="not_useful">The platform isn't useful for me</option>
                            <option value="too_many_emails">Too many emails/notifications</option>
                            <option value="other">Other reason</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest ml-1">Confirm with password</label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-red-500/10 font-bold text-slate-800 transition-all">
                        @error('delete_password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-red-50 p-6 rounded-2xl border border-red-100 flex items-start space-x-4">
                        <svg class="w-6 h-6 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-xs text-red-600 font-bold leading-relaxed">Warning: This action is permanent. All your data, including service history, messages, and profile information, will be deleted forever.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button type="submit" class="flex-1 py-4 bg-red-600 text-white rounded-2xl font-extrabold text-lg hover:bg-red-700 transition shadow-xl active:scale-95">Permanently Delete My Account</button>
                        <button type="button" @click="showDelete = false" class="px-8 py-4 bg-slate-100 text-slate-600 rounded-2xl font-extrabold hover:bg-slate-200 transition">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
