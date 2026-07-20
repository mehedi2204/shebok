@extends('layouts.admin')

@section('title', 'Manage Packages')

@section('content')
<div class="space-y-8" x-data="{ showForm: false }">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Subscription Packages</h2>
            <p class="text-slate-500 text-sm">Create and manage listing packages for service providers.</p>
        </div>
        <button @click="showForm = !showForm" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition flex items-center space-x-2">
            <svg class="w-5 h-5" :class="{'rotate-45': showForm}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            <span x-text="showForm ? 'Cancel' : 'Add New Package'">Add New Package</span>
        </button>
    </div>

    <!-- Create Package Form -->
    <div x-show="showForm" x-transition class="bg-white p-8 rounded-[2rem] shadow-[0_15px_50px_-15px_rgba(0,0,0,0.02)] border border-slate-50">
        <h3 class="text-lg font-extrabold text-slate-800 mb-6">Create New Package</h3>
        <form action="{{ route('admin.packages.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Package Name</label>
                    <input type="text" name="name" required placeholder="e.g. Premium" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Price (BDT)</label>
                    <input type="number" name="price" required placeholder="1500" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Duration (Days)</label>
                    <input type="number" name="duration_days" required placeholder="30" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Features (Comma separated)</label>
                <textarea name="features" rows="2" placeholder="Featured Listing, Priority Support, Analytics Dashboard" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-600 transition shadow-xl active:scale-95">Create Package</button>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-100 text-green-600 px-6 py-4 rounded-2xl font-bold text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($packages as $package)
        <div class="bg-white rounded-[2rem] border {{ $loop->index == 1 ? 'border-2 border-blue-600 shadow-xl shadow-blue-100' : 'border-slate-100 shadow-sm' }} p-8 relative overflow-hidden flex flex-col">
            @if($loop->index == 1)
                <div class="absolute top-0 right-0 bg-blue-600 text-white px-6 py-2 rounded-bl-2xl text-xs font-bold uppercase tracking-widest">Popular</div>
            @endif
            <div class="mb-8">
                <h3 class="text-xl font-bold text-slate-800">{{ $package->name }}</h3>
                <p class="text-slate-400 text-sm">Duration: {{ $package->duration_days }} days</p>
            </div>
            <div class="mb-8">
                <span class="text-4xl font-extrabold text-slate-900">৳{{ number_format($package->price) }}</span>
            </div>
            <ul class="space-y-4 mb-10 flex-grow">
                @if($package->features)
                    @foreach($package->features as $feature)
                    <li class="flex items-center space-x-3 text-sm text-slate-600 font-medium">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                @endif
            </ul>
            <div class="flex space-x-3 mt-auto">
                <button class="flex-1 py-3 {{ $loop->index == 1 ? 'bg-blue-600 text-white' : 'border border-slate-100 text-slate-600' }} rounded-xl font-bold hover:opacity-90 transition">Edit</button>
                <form action="{{ route('admin.packages.delete', $package->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this package?')" class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
