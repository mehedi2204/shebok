@extends('layouts.admin')

@section('title', 'Edit Service Type')

@section('content')
<div class="flex flex-col gap-8">
    <div class="bg-white p-8 rounded-[2rem] shadow-[0_15px_50px_-15px_rgba(0,0,0,0.02)] border border-slate-50">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-extrabold text-slate-800">Edit Service Type: {{ $category->name }}</h3>
            <a href="{{ route('admin.categories') }}" class="text-slate-400 hover:text-slate-600 font-bold text-sm flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Back to List</span>
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Service Name</label>
                    <input type="text" name="name" required value="{{ $category->name }}" placeholder="e.g. Home Nursing" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Tagline</label>
                    <input type="text" name="tagline" value="{{ $category->tagline }}" placeholder="Short description" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-3xl space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-slate-700">Service Icon Selection</h4>
                    <div class="text-[10px] font-black uppercase text-blue-600 bg-blue-50 px-3 py-1 rounded-lg">
                        Current:
                        @if(Str::startsWith($category->icon, 'storage/'))
                            [Image]
                        @else
                            {{ $category->icon }}
                        @endif
                    </div>
                </div>

                @php $isUpload = Str::startsWith($category->icon, 'storage/'); @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center space-x-3 mb-4 cursor-pointer">
                            <input type="radio" name="icon_type" value="predefined" {{ !$isUpload ? 'checked' : '' }} onclick="toggleIconInput('predefined')" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-bold text-slate-600">Choose Predefined Icon</span>
                        </label>
                        <select id="icon_predefined" name="icon_predefined" {{ $isUpload ? 'disabled' : '' }} class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold appearance-none {{ $isUpload ? 'opacity-50' : '' }}">
                            @php
                                $icons = ['🩺', '💪', '👴', '🚑', '💊', '🦷', '🦴', '🩸', '🏥'];
                            @endphp
                            @foreach($icons as $icon)
                                <option value="{{ $icon }}" {{ $category->icon == $icon ? 'selected' : '' }}>{{ $icon }} Icon</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 mb-4 cursor-pointer">
                            <input type="radio" name="icon_type" value="upload" {{ $isUpload ? 'checked' : '' }} onclick="toggleIconInput('upload')" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-bold text-slate-600">Upload New Custom Icon</span>
                        </label>
                        <input type="file" id="icon_upload" name="icon_upload" {{ !$isUpload ? 'disabled' : '' }} class="w-full px-6 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 {{ !$isUpload ? 'opacity-50' : '' }}">
                        @if($isUpload)
                            <div class="mt-2 ml-2 flex items-center space-x-2">
                                <img src="{{ asset($category->icon) }}" class="w-8 h-8 object-contain">
                                <span class="text-[10px] text-slate-400 font-bold uppercase">Keep current or upload new</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-3xl space-y-4">
                <h4 class="text-sm font-bold text-slate-700">Verification Document Requirements</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" class="peer hidden" checked disabled>
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600">NID / Passport (Always Required)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="require_certificate" value="1" {{ $category->require_certificate ? 'checked' : '' }} class="peer hidden">
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600">Educational Certificate (Required?)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="require_experience" value="1" {{ $category->require_experience ? 'checked' : '' }} class="peer hidden">
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600">Experience Certificate (Required?)</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center space-x-4 pt-4">
                <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-600 transition shadow-xl active:scale-95">
                    Update Service Type
                </button>
                <a href="{{ route('admin.categories') }}" class="px-10 py-4 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleIconInput(type) {
        const predefined = document.getElementById('icon_predefined');
        const upload = document.getElementById('icon_upload');

        if (type === 'predefined') {
            predefined.disabled = false;
            predefined.classList.remove('opacity-50');
            upload.disabled = true;
            upload.classList.add('opacity-50');
        } else {
            predefined.disabled = true;
            predefined.classList.add('opacity-50');
            upload.disabled = false;
            upload.classList.remove('opacity-50');
        }
    }
</script>
@endsection
