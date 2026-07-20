@extends('layouts.admin')

@section('title', 'User Profile: ' . $user->name)

@section('content')
<div class="space-y-8">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.users') }}" class="p-3 bg-white rounded-2xl shadow-sm border border-slate-100 text-slate-400 hover:text-blue-600 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Member Details</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-50 text-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-32 h-32 rounded-[2.5rem] mx-auto mb-6 shadow-xl shadow-slate-200 object-cover">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=128&background=random" class="w-32 h-32 rounded-[2.5rem] mx-auto mb-6 shadow-xl shadow-slate-200">
                @endif
                <h3 class="text-2xl font-extrabold text-slate-900">{{ $user->name }}</h3>
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mt-1">{{ $user->role }}</p>

                <div class="mt-8 pt-8 border-t border-slate-50 grid grid-cols-2 gap-4">
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Status</p>
                        <span class="px-3 py-1 {{ $user->is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-lg text-[10px] font-bold uppercase">
                            {{ $user->is_active ? 'Active' : 'Banned' }}
                        </span>
                    </div>
                    <div class="text-left">
                        <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-1">Verified</p>
                        <span class="px-3 py-1 {{ $user->email_verified_at ? 'bg-blue-50 text-blue-600' : 'bg-slate-50 text-slate-400' }} rounded-lg text-[10px] font-bold uppercase">
                            {{ $user->email_verified_at ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-8 rounded-[2.5rem] text-white">
                <h4 class="text-sm font-black uppercase tracking-[0.2em] text-slate-500 mb-6">Contact Info</h4>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Email Address</p>
                        <p class="font-bold tracking-tight">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Joined On</p>
                        <p class="font-bold tracking-tight">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Content -->
        <div class="lg:col-span-2 space-y-8">
            @php $profile = $user->providerProfile; @endphp
            @if($profile)
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-50">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">Professional Profile</h4>
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Service category & verification</p>
                    </div>
                    <span class="px-4 py-2 bg-{{ $profile->status === 'approved' ? 'green' : ($profile->status === 'pending' ? 'orange' : 'red') }}-50 text-{{ $profile->status === 'approved' ? 'green' : ($profile->status === 'pending' ? 'orange' : 'red') }}-600 rounded-xl text-xs font-black uppercase tracking-widest">
                        {{ $profile->status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Profession</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $profile->profession }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Years of Experience</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $profile->experience ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Category</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $profile->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Expected Rate</p>
                            <p class="text-lg font-extrabold text-slate-800">৳{{ number_format($profile->price_per_hour) }} <span class="text-sm font-medium text-slate-400">/ {{ $profile->rate_type ?? 'hour' }}</span></p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Location</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $profile->location }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Thana / Upazila</p>
                            <p class="text-lg font-extrabold text-slate-800">{{ $profile->thana_upazila ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-2">Full Address</p>
                            <p class="text-slate-600 font-medium">{{ $profile->address }}</p>
                        </div>
                    </div>
                </div>

                @if($profile->bio)
                <div class="mt-10 p-8 bg-slate-50 rounded-[2rem] border border-slate-100">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-4">Professional Bio</p>
                    <p class="text-slate-600 leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif

                @if($profile->additional_data)
                <div class="mt-12 pt-10 border-t border-slate-50">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-6">Additional Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($profile->additional_data as $label => $value)
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $label }}</p>
                            <p class="font-bold text-slate-700">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-12 pt-10 border-t border-slate-50">
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest mb-6">Verification Documents</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @if($profile->nid_path)
                        <a href="{{ asset('storage/' . $profile->nid_path) }}" target="_blank" class="p-6 bg-slate-50 rounded-3xl text-center hover:bg-blue-50 transition group">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">NID / Passport</span>
                        </a>
                        @endif
                        @if($profile->license_path)
                        <a href="{{ asset('storage/' . $profile->license_path) }}" target="_blank" class="p-6 bg-slate-50 rounded-3xl text-center hover:bg-blue-50 transition group">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">License</span>
                        </a>
                        @endif
                        @if($profile->certificate_path)
                        <a href="{{ asset('storage/' . $profile->certificate_path) }}" target="_blank" class="p-6 bg-slate-50 rounded-3xl text-center hover:bg-blue-50 transition group">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Certificate</span>
                        </a>
                        @endif
                        @if($profile->experience_path)
                        <a href="{{ asset('storage/' . $profile->experience_path) }}" target="_blank" class="p-6 bg-slate-50 rounded-3xl text-center hover:bg-blue-50 transition group">
                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Experience Proof</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-50">
                <h4 class="text-xl font-extrabold text-slate-900 tracking-tight mb-8">Admin Actions</h4>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-8 py-4 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition">
                        Edit Account Info
                    </a>

                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-8 py-4 {{ $user->is_active ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600' }} rounded-2xl font-bold transition">
                            {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>

                    @if($profile)
                        @if($profile->status === 'pending')
                            <form action="{{ route('admin.approve-provider', $profile->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold shadow-xl shadow-blue-200">Approve Application</button>
                            </form>
                            <form action="{{ route('admin.reject-provider', $profile->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-8 py-4 bg-orange-50 text-orange-600 rounded-2xl font-bold">Reject Application</button>
                            </form>
                        @elseif($profile->status === 'approved')
                             <form action="{{ route('admin.reject-provider', $profile->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-8 py-4 bg-orange-50 text-orange-600 rounded-2xl font-bold">Cancel Approval</button>
                            </form>
                        @endif
                    @endif

                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Danger: This action cannot be undone. Delete?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-8 py-4 border border-red-100 text-red-400 hover:bg-red-50 rounded-2xl font-bold transition">Permanently Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
