@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-50 overflow-hidden">
            <div class="p-8 border-b border-slate-50">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Conversations</h2>
                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest mt-1">Manage your chats with service providers</p>
            </div>

            <div class="divide-y divide-slate-50">
                @forelse($conversations as $conversation)
                    @php
                        $otherUser = $conversation->sender_id == Auth::id() ? $conversation->receiver : $conversation->sender;
                    @endphp
                    <a href="{{ route('chat.show', $conversation->id) }}" class="flex items-center p-6 hover:bg-slate-50 transition group">
                        @if($otherUser->avatar)
                            <img src="{{ asset('storage/' . $otherUser->avatar) }}" class="w-16 h-16 rounded-2xl shadow-lg mr-6 object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=random" class="w-16 h-16 rounded-2xl shadow-lg mr-6">
                        @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="text-lg font-extrabold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $otherUser->name }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $conversation->latestMessage ? $conversation->latestMessage->created_at->diffForHumans() : '' }}</span>
                            </div>
                            <p class="text-slate-500 font-medium line-clamp-1">
                                {{ $conversation->latestMessage ? $conversation->latestMessage->body : 'No messages yet' }}
                            </p>
                        </div>
                        @php
                            $unreadCount = $conversation->messages()->where('user_id', '!=', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <div class="ml-4 bg-blue-600 text-white text-[10px] font-black w-6 h-6 rounded-lg flex items-center justify-center">
                                {{ $unreadCount }}
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="p-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800 mb-2">No conversations yet</h3>
                        <p class="text-slate-500 font-medium mb-8">Start a conversation with a service provider to see it here.</p>
                        <a href="/services" class="inline-block bg-blue-600 text-white px-8 py-3.5 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition">Find Services</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
