@extends('layouts.admin')

@section('title', 'Pending Approvals')

@section('content')
<div class="space-y-12">
    <!-- New Applications -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-50 overflow-hidden">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-slate-50/20">
            <div>
                <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">New Provider Applications</h4>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Review and verify new service givers</p>
            </div>
            <div class="flex space-x-2">
                <span class="bg-orange-50 text-orange-600 px-4 py-2 rounded-xl text-xs font-bold">{{ $pendingProviders->count() }} Pending</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 font-extrabold text-[10px] uppercase tracking-[0.2em]">
                        <th class="px-10 py-6">Applicant</th>
                        <th class="px-10 py-6">Service Type</th>
                        <th class="px-10 py-6">Price/Hr</th>
                        <th class="px-10 py-6">Location</th>
                        <th class="px-10 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendingProviders as $p)
                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                        <td class="px-10 py-6">
                            <div class="flex items-center space-x-4">
                                @if($p->user->avatar)
                                    <img src="{{ asset('storage/' . $p->user->avatar) }}" class="w-12 h-12 rounded-2xl shadow-sm object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($p->user->name) }}&background=random" class="w-12 h-12 rounded-2xl shadow-sm">
                                @endif
                                <div>
                                    <p class="font-extrabold text-slate-800 tracking-tight">{{ $p->user->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium">{{ $p->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-extrabold px-4 py-1.5 rounded-xl tracking-wider uppercase">{{ $p->category->name }}</span>
                        </td>
                        <td class="px-10 py-6 text-xs font-bold text-slate-600 uppercase tracking-widest">
                            ৳{{ $p->price_per_hour }}
                        </td>
                        <td class="px-10 py-6">
                            <p class="text-xs font-bold text-slate-600 tracking-tight">{{ $p->location }}</p>
                        </td>
                        <td class="px-10 py-6 text-right space-x-2">
                            <a href="{{ route('admin.users.show', $p->user_id) }}" class="inline-block bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-200 transition">View Details</a>
                            <form action="{{ route('admin.approve-provider', $p->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-green-600 transition shadow-lg shadow-green-200">Approve</button>
                            </form>
                            <form action="{{ route('admin.reject-provider', $p->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-50 text-red-500 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition">Reject</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold italic">No pending applications.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Information Update Requests -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-50 overflow-hidden">
        <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-blue-50/20">
            <div>
                <h4 class="text-2xl font-extrabold text-slate-900 tracking-tight">Information Update Requests</h4>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Review changes requested by active providers</p>
            </div>
            <div class="flex space-x-2">
                <span class="bg-blue-50 text-blue-600 px-4 py-2 rounded-xl text-xs font-bold">{{ $updateRequests->count() }} Pending</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 font-extrabold text-[10px] uppercase tracking-[0.2em]">
                        <th class="px-10 py-6">Provider</th>
                        <th class="px-10 py-6">Field</th>
                        <th class="px-10 py-6">Current Value</th>
                        <th class="px-10 py-6">Requested Value</th>
                        <th class="px-10 py-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($updateRequests as $r)
                    @php
                        $requested = $r->pending_update;
                        $diffs = [];
                        if($r->profession != $requested['profession']) $diffs['Profession'] = [$r->profession, $requested['profession']];
                        if($r->price_per_hour != $requested['price_per_hour']) $diffs['Rate'] = [$r->price_per_hour, $requested['price_per_hour']];
                        if($r->rate_type != ($requested['rate_type'] ?? 'hourly')) $diffs['Rate Type'] = [$r->rate_type, $requested['rate_type'] ?? 'hourly'];
                        if($r->location != $requested['location']) $diffs['Location'] = [$r->location, $requested['location']];
                        if($r->address != $requested['address']) $diffs['Address'] = [$r->address, $requested['address']];
                        // Additional data comparison
                        foreach($requested['additional_data'] ?? [] as $key => $val) {
                            if(($r->additional_data[$key] ?? '') != $val) {
                                $diffs[$key] = [$r->additional_data[$key] ?? 'N/A', $val];
                            }
                        }
                    @endphp
                    @foreach($diffs as $field => $vals)
                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                        @if($loop->first)
                        <td class="px-10 py-6" rowspan="{{ count($diffs) }}">
                            <div class="flex items-center space-x-4">
                                @if($r->user->avatar)
                                    <img src="{{ asset('storage/' . $r->user->avatar) }}" class="w-10 h-10 rounded-xl shadow-sm object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($r->user->name) }}&background=random" class="w-10 h-10 rounded-xl shadow-sm">
                                @endif
                                <div>
                                    <p class="font-extrabold text-slate-800 tracking-tight text-sm">{{ $r->user->name }}</p>
                                    <p class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">{{ $r->category->name }}</p>
                                </div>
                            </div>
                        </td>
                        @endif
                        <td class="px-10 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">{{ $field }}</td>
                        <td class="px-10 py-6 text-sm text-slate-500 font-medium">{{ $vals[0] }}</td>
                        <td class="px-10 py-6 text-sm text-blue-600 font-bold">{{ $vals[1] }}</td>
                        @if($loop->first)
                        <td class="px-10 py-6 text-right space-x-2" rowspan="{{ count($diffs) }}">
                            <a href="{{ route('admin.users.show', $r->user_id) }}" class="inline-block bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-200 transition">View Details</a>
                            <form action="{{ route('admin.approve-update', $r->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-700 transition">Approve</button>
                            </form>
                            <form action="{{ route('admin.reject-update', $r->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-50 text-red-500 px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-red-500 hover:text-white transition">Reject</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-20 text-center text-slate-400 font-bold italic">No update requests.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
