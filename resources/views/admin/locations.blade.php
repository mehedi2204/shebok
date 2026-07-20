@extends('layouts.admin')

@section('title', 'Location Management')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Country Management -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-50">
        <h3 class="text-lg font-extrabold text-slate-800 mb-6">Countries</h3>
        <form action="{{ route('admin.locations.store') }}" method="POST" class="space-y-4 mb-8">
            @csrf
            <input type="hidden" name="type" value="country">
            <input type="text" name="name" required placeholder="Country Name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition">Add Country</button>
        </form>
        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
            @foreach($countries as $c)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group">
                <span class="font-bold text-slate-700">{{ $c->name }}</span>
                <form action="{{ route('admin.locations.delete', $c->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition" onclick="return confirm('Delete this country?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Division/State Management -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-50">
        <h3 class="text-lg font-extrabold text-slate-800 mb-6">Divisions / States</h3>
        <form action="{{ route('admin.locations.store') }}" method="POST" class="space-y-4 mb-8">
            @csrf
            <input type="hidden" name="type" value="division">
            <select name="parent_id" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold appearance-none">
                <option value="">Select Country</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
            <input type="text" name="name" required placeholder="Division Name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition">Add Division</button>
        </form>
        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
            @foreach($divisions as $d)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group">
                <div>
                    <span class="font-bold text-slate-700 block">{{ $d->name }}</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $d->parent->name }}</span>
                </div>
                <form action="{{ route('admin.locations.delete', $d->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition" onclick="return confirm('Delete this division?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    <!-- City/Area Management -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-50">
        <h3 class="text-lg font-extrabold text-slate-800 mb-6">Cities / Areas</h3>
        <form action="{{ route('admin.locations.store') }}" method="POST" class="space-y-4 mb-8">
            @csrf
            <input type="hidden" name="type" value="city">
            <select name="parent_id" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold appearance-none">
                <option value="">Select Division</option>
                @foreach($divisions as $d)
                    <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->parent->name }})</option>
                @endforeach
            </select>
            <input type="text" name="name" required placeholder="City/Area Name" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
            <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-blue-600 transition">Add City</button>
        </form>
        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2">
            @foreach($cities as $c)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl group">
                <div>
                    <span class="font-bold text-slate-700 block">{{ $c->name }}</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $c->parent->name }}</span>
                </div>
                <form action="{{ route('admin.locations.delete', $c->id) }}" method="POST" class="opacity-0 group-hover:opacity-100 transition-opacity">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-400 hover:text-red-600 transition" onclick="return confirm('Delete this city/area?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
