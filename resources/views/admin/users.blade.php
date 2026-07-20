@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-[0_30px_80px_-20px_rgba(0,0,0,0.05)] border border-slate-50 overflow-hidden">
    <div class="p-10 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center bg-slate-50/20 gap-6">
        <div>
            <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">Active Members</h4>
            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Givers & Seekers across the platform</p>
        </div>
        <div class="flex items-center space-x-4 w-full md:w-auto">
            <button onclick="document.getElementById('filter-section').classList.toggle('hidden')" class="bg-white text-slate-600 px-6 py-3 rounded-2xl font-bold border border-slate-100 shadow-sm hover:bg-slate-50 transition active:scale-95 text-sm flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filters
            </button>
            <button class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-600 transition shadow-lg active:scale-95 text-sm">Export</button>
        </div>
    </div>

    <!-- Filter Section -->
    <div id="filter-section" class="{{ request()->anyFilled(['search', 'status', 'approval', 'category_id', 'country_id']) ? '' : 'hidden' }} p-10 bg-slate-50/50 border-b border-slate-50">
        <form action="{{ route('admin.users') }}" method="GET" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Search -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Search User</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="w-full pl-11 pr-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm">
                        <svg class="w-5 h-5 absolute left-4 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Account Status</label>
                    <select name="status" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <!-- Approval Status -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Approval Status</label>
                    <select name="approval" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">All Applications</option>
                        <option value="pending" {{ request('approval') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('approval') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('approval') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Service Type -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Service Type</label>
                    <select name="category_id" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Country -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Country</label>
                    <select name="country_id" id="country_id" onchange="loadChildren(this.value, 'division_id')" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Division -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">Division</label>
                    <select name="division_id" id="division_id" onchange="loadChildren(this.value, 'district_id')" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">Select Division</option>
                    </select>
                </div>

                <!-- District -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest ml-1">District / City</label>
                    <select name="district_id" id="district_id" class="w-full px-4 py-3 bg-white border-none rounded-2xl focus:ring-4 focus:ring-blue-500/10 text-sm font-semibold shadow-sm appearance-none">
                        <option value="">Select District</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-3">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 text-sm">Apply Filters</button>
                    <a href="{{ route('admin.users') }}" class="px-6 py-3 bg-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-300 transition text-sm">Reset</a>
                </div>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="m-6 p-4 bg-green-50 text-green-600 rounded-2xl font-bold text-sm border border-green-100">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="m-6 p-4 bg-red-50 text-red-600 rounded-2xl font-bold text-sm border border-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 font-extrabold text-[10px] uppercase tracking-[0.2em]">
                    <th class="px-10 py-6">Member</th>
                    <th class="px-10 py-6">Role</th>
                    <th class="px-10 py-6">Account Status</th>
                    <th class="px-10 py-6">Verification</th>
                    <th class="px-10 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/50 transition-all duration-300">
                    <td class="px-10 py-6">
                        <div class="flex items-center space-x-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-11 h-11 rounded-2xl shadow-sm object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-11 h-11 rounded-2xl shadow-sm">
                            @endif
                            <div>
                                <p class="font-extrabold text-slate-800 tracking-tight">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        <div class="flex flex-col">
                            <span class="px-3 py-1 bg-{{ $user->role === 'admin' ? 'red' : 'purple' }}-50 text-{{ $user->role === 'admin' ? 'red' : 'purple' }}-600 rounded-lg text-[10px] font-bold tracking-wider uppercase w-fit">
                                {{ $user->role }}
                            </span>
                            @if($user->providerProfile)
                                <span class="mt-1 text-[9px] font-black uppercase text-blue-600 tracking-tighter">
                                    {{ $user->providerProfile->status }} Provider
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-10 py-6">
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 {{ $user->is_active ? 'text-green-600' : 'text-slate-400' }}">
                                <div class="w-10 h-5 bg-slate-200 rounded-full relative transition-colors {{ $user->is_active ? '!bg-green-500' : '' }}">
                                    <div class="absolute top-1 left-1 w-3 h-3 bg-white rounded-full transition-transform {{ $user->is_active ? 'translate-x-5' : '' }}"></div>
                                </div>
                                <span class="text-[10px] font-bold uppercase tracking-widest">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                            </button>
                        </form>
                    </td>
                    <td class="px-10 py-6">
                        @if($user->providerProfile && $user->providerProfile->status === 'approved')
                        <div class="flex items-center space-x-2 text-green-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-[10px] font-extrabold uppercase">Verified</span>
                        </div>
                        @else
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Pending</span>
                        @endif
                    </td>
                    <td class="px-10 py-6 text-right">
                        <div class="flex justify-end items-center space-x-2">
                            <!-- View Button -->
                            <a href="{{ route('admin.users.show', $user->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>

                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Edit User">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <!-- Provider Specific Actions -->
                            @if($user->role === 'provider' && $user->providerProfile)
                                @if($user->providerProfile->status === 'pending')
                                    <form action="{{ route('admin.approve-provider', $user->providerProfile->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-green-500 hover:bg-green-50 rounded-xl transition" title="Approve Provider">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reject-provider', $user->providerProfile->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-orange-500 hover:bg-orange-50 rounded-xl transition" title="Reject/Cancel Request">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            @endif

                            <!-- Delete Button -->
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition" onclick="return confirm('Permanently delete this user?')" title="Delete User">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h14"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-10 bg-slate-50/20 border-t border-slate-50">
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function loadChildren(parentId, targetId, selectedId = null) {
        if (!parentId) return;

        const targetSelect = document.getElementById(targetId);
        targetSelect.innerHTML = '<option value="">Loading...</option>';

        if (targetId === 'division_id') {
            document.getElementById('district_id').innerHTML = '<option value="">Select District</option>';
        }

        try {
            const response = await fetch(`/api/locations/${parentId}/children`);
            const data = await response.json();

            targetSelect.innerHTML = `<option value="">Select ${targetId === 'division_id' ? 'Division' : 'District'}</option>`;
            data.forEach(item => {
                const selected = selectedId == item.id ? 'selected' : '';
                targetSelect.innerHTML += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            });

            // If we just loaded divisions and there's a selected division, load its districts
            if (targetId === 'division_id' && selectedId) {
                const districtId = '{{ request('district_id') }}';
                loadChildren(selectedId, 'district_id', districtId);
            }
        } catch (error) {
            console.error('Error fetching locations:', error);
            targetSelect.innerHTML = '<option value="">Error loading</option>';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const countryId = '{{ request('country_id') }}';
        const divisionId = '{{ request('division_id') }}';
        const districtId = '{{ request('district_id') }}';

        if (countryId) {
            loadChildren(countryId, 'division_id', divisionId);
        }
    });
</script>
@endpush
