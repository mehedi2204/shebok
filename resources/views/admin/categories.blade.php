@extends('layouts.admin')

@section('title', 'Service Management')

@section('content')
<div class="flex flex-col gap-8">
    <!-- Add New Service Type -->
    <div class="bg-white p-8 rounded-[2rem] shadow-[0_15px_50px_-15px_rgba(0,0,0,0.02)] border border-slate-50">
        <h3 class="text-xl font-extrabold text-slate-800 mb-6">Create New Service Type</h3>
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Service Name</label>
                    <input type="text" name="name" required placeholder="e.g. Home Nursing" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-2">Tagline</label>
                    <input type="text" name="tagline" placeholder="Short description" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold">
                </div>
            </div>

            <div class="bg-slate-50 p-6 rounded-3xl space-y-4">
                <h4 class="text-sm font-bold text-slate-700">Service Icon Selection</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center space-x-3 mb-4 cursor-pointer">
                            <input type="radio" name="icon_type" value="predefined" checked onclick="toggleIconInput('predefined')" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-bold text-slate-600">Choose Predefined Icon</span>
                        </label>
                        <select id="icon_predefined" name="icon_predefined" class="w-full px-6 py-4 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold appearance-none">
                            <option value="🩺">🩺 Stethoscope</option>
                            <option value="💪">💪 Physiotherapy</option>
                            <option value="👴">👴 Elderly Care</option>
                            <option value="🚑">🚑 Ambulance</option>
                            <option value="💊">💊 Pharmacy</option>
                            <option value="🦷">🦷 Dental</option>
                            <option value="🦴">🦴 Orthopedic</option>
                            <option value="🩸">🩸 Blood Test</option>
                            <option value="🏥">🏥 Hospital</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 mb-4 cursor-pointer">
                            <input type="radio" name="icon_type" value="upload" onclick="toggleIconInput('upload')" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-bold text-slate-600">Upload Custom Icon</span>
                        </label>
                        <input type="file" id="icon_upload" name="icon_upload" disabled class="w-full px-6 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/20 font-semibold text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 opacity-50">
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
                            <input type="checkbox" name="require_certificate" value="1" class="peer hidden">
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600">Educational Certificate (Required?)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="require_experience" value="1" class="peer hidden">
                            <div class="w-12 h-6 bg-slate-200 rounded-full peer-checked:bg-blue-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-bold text-slate-600">Experience Certificate (Required?)</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold hover:bg-blue-700 transition shadow-xl shadow-blue-500/20">
                Add Service Type
            </button>
        </form>
    </div>

    <!-- Service List -->
    <div class="bg-white rounded-[2.5rem] shadow-[0_30px_80px_-20px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
            <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">Available Services</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 font-extrabold text-[10px] uppercase tracking-[0.2em]">
                        <th class="px-10 py-6">Icon</th>
                        <th class="px-10 py-6">Service Name</th>
                        <th class="px-10 py-6">Tagline</th>
                        <th class="px-10 py-6">Providers</th>
                        <th class="px-10 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($categories as $service)
                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                        <td class="px-10 py-6">
                            @if(Str::startsWith($service->icon, 'storage/'))
                                <img src="{{ asset($service->icon) }}" class="w-10 h-10 object-contain">
                            @else
                                <span class="text-2xl">{{ $service->icon }}</span>
                            @endif
                        </td>
                        <td class="px-10 py-6">
                            <p class="font-extrabold text-slate-800 tracking-tight">{{ $service->name }}</p>
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-slate-500 font-medium">{{ $service->tagline }}</p>
                        </td>
                        <td class="px-10 py-6 font-bold text-slate-600">{{ $service->providers_count }}</td>
                        <td class="px-10 py-6 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $service->id) }}" class="inline-block p-3 text-blue-600 hover:bg-blue-50 rounded-2xl transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.categories.delete', $service->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition" onclick="return confirm('Are you sure?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleIconInput(type) {
        const predefined = document.getElementById('icon_predefined');
        const upload = document.getElementById('icon_upload');

        if (type === 'predefined') {
            predefined.disabled = false;
            predefined.parentElement.classList.remove('opacity-50');
            upload.disabled = true;
            upload.classList.add('opacity-50');
        } else {
            predefined.disabled = true;
            predefined.parentElement.classList.add('opacity-50');
            upload.disabled = false;
            upload.classList.remove('opacity-50');
        }
    }
</script>
@endsection
