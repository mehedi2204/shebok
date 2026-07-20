@extends('layouts.admin')

@section('title', 'Form Builder Intelligence')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <!-- Category Selection Sidebar -->
    <div class="w-full lg:w-96 shrink-0">
        <div class="bg-white p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.02)] border border-slate-50 sticky top-32">
            <div class="mb-8">
                <span class="text-blue-600 font-extrabold tracking-[0.2em] uppercase text-[10px] block mb-2">Step 1</span>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Select Category</h3>
            </div>

            <div class="space-y-3">
                @foreach($categories as $cat)
                <a href="{{ route('admin.form-builder', ['category_id' => $cat->id]) }}" class="w-full p-5 rounded-2xl flex items-center justify-between group transition-all duration-300 {{ ($selectedCategory && $selectedCategory->id == $cat->id) ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20' : 'bg-slate-50 text-slate-600 hover:bg-slate-100' }}">
                    <span class="font-bold tracking-tight">{{ $cat->name }}</span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
                @endforeach
            </div>

            <div class="mt-10 p-6 bg-slate-900 rounded-3xl text-white">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Context</p>
                <p class="text-sm font-medium leading-relaxed opacity-80 italic">"Defined fields will appear as required inputs when a user tries to post in this category."</p>
            </div>
        </div>
    </div>

    <!-- Builder Area -->
    <div class="flex-1">
        @if($selectedCategory)
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_80px_-20px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
            <div class="p-8 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center bg-slate-50/20 gap-6">
                <div>
                    <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">Fields for "{{ $selectedCategory->name }}"</h4>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Configure dynamic input schema</p>
                </div>
            </div>

            <div class="p-8 sm:p-10 bg-slate-50/30 border-b border-slate-50">
                <h5 class="text-sm font-extrabold text-slate-800 mb-4 uppercase tracking-wider">Add New Field</h5>
                <form action="{{ route('admin.form-builder.store-field') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $selectedCategory->id }}">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Field Label</label>
                        <input type="text" name="label" required placeholder="e.g. Qualification" class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-600/20 outline-none font-semibold text-sm">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Field Type</label>
                        <select name="type" required class="w-full px-4 py-3 bg-white border border-slate-100 rounded-xl focus:ring-2 focus:ring-blue-600/20 outline-none font-semibold text-sm appearance-none">
                            <option value="text">Text Input</option>
                            <option value="number">Number</option>
                            <option value="file">File Upload</option>
                            <option value="dropdown">Dropdown Selection</option>
                        </select>
                    </div>
                    <div class="md:col-span-1 flex items-center mb-3">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 rounded text-blue-600">
                            <span class="text-xs font-bold text-slate-600">Required</span>
                        </label>
                    </div>
                    <div class="md:col-span-1">
                        <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold hover:bg-blue-600 transition shadow-lg text-sm">Add Field</button>
                    </div>
                </form>
            </div>

            <div class="p-8 sm:p-10 space-y-4">
                @forelse($fields as $field)
                <div class="flex items-center justify-between p-6 bg-white rounded-3xl border border-slate-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 group">
                    <div class="flex items-center space-x-6 min-w-0">
                        <div class="text-slate-200 group-hover:text-blue-200 transition-colors shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="font-extrabold text-slate-800 tracking-tight truncate text-lg">{{ $field->label }}</p>
                            <div class="flex items-center space-x-3 mt-1">
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-slate-50 px-2.5 py-1 rounded-lg">Type: {{ $field->type }}</span>
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $field->is_required ? 'text-blue-600 bg-blue-50' : 'text-slate-400 bg-slate-50' }} px-2.5 py-1 rounded-lg">{{ $field->is_required ? 'Required' : 'Optional' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('admin.form-builder.delete-field', $field->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition" onclick="return confirm('Are you sure?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <p class="text-slate-400 font-bold italic">No custom fields defined for this category yet.</p>
                </div>
                @endforelse
            </div>
        </div>
        @else
        <div class="bg-white rounded-[2.5rem] p-20 text-center border border-slate-50">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <h4 class="text-xl font-extrabold text-slate-900 mb-2">Select a Category to Start</h4>
            <p class="text-slate-400 font-medium">Choose a service category from the left to manage its dynamic fields.</p>
        </div>
        @endif
    </div>
</div>
@endsection
