@extends('layouts.admin')

@section('title', 'Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-600">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Users</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-green-600">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Providers</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_providers']) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-purple-600">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pending Approvals</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['pending_approvals']) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-600">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-lg mr-4">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Categories</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_categories']) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h4 class="font-bold text-gray-800">New Providers</h4>
            <a href="{{ url('admin/approvals') }}" class="text-blue-600 text-sm font-semibold hover:underline">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Provider</th>
                        <th class="px-6 py-4 font-semibold">Category</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php $newProviders = \App\Models\ProviderProfile::with('user', 'category')->latest()->take(5)->get(); @endphp
                    @forelse($newProviders as $provider)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($provider->user->name) }}&background=random" class="w-8 h-8 rounded-full mr-3">
                                <span class="font-medium text-sm">{{ $provider->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $provider->category->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-{{ $provider->status == 'approved' ? 'green' : ($provider->status == 'pending' ? 'yellow' : 'red') }}-100 text-{{ $provider->status == 'approved' ? 'green' : ($provider->status == 'pending' ? 'yellow' : 'red') }}-700 rounded-full text-[10px] font-bold uppercase">
                                {{ $provider->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400 italic">No providers yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h4 class="font-bold text-gray-800">Recent Messages</h4>
            <a href="{{ route('admin.messages') }}" class="text-blue-600 text-sm font-semibold hover:underline">View All</a>
        </div>
        <div class="p-6">
            @php $recentMessages = \App\Models\ContactMessage::latest()->take(5)->get(); @endphp
            <div class="space-y-4">
                @forelse($recentMessages as $msg)
                <a href="{{ route('admin.messages.show', $msg->id) }}" class="block p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex justify-between items-start mb-1">
                        <h5 class="font-bold text-sm text-gray-800">{{ $msg->name }}</h5>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-500 line-clamp-1">{{ $msg->subject ?? 'No Subject' }}</p>
                </a>
                @empty
                <p class="text-center text-gray-400 italic text-sm">No messages yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
