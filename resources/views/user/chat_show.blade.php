@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-50 overflow-hidden flex flex-col h-[700px]">
            @php $otherUser = $conversation->sender_id == Auth::id() ? $conversation->receiver : $conversation->sender; @endphp
            <!-- Chat Header -->
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('chat.index') }}" class="p-2 mr-4 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    @if($otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}" class="w-12 h-12 rounded-xl shadow-md mr-4 object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&background=random" class="w-12 h-12 rounded-xl shadow-md mr-4">
                    @endif
                    <div>
                        <h4 class="text-lg font-extrabold text-slate-800 leading-none mb-1">{{ $otherUser->name }}</h4>
                        <div class="flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Active Now</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-8 space-y-6 scroll-smooth bg-slate-50/50" id="message-container">
                @foreach($conversation->messages as $message)
                    <div class="flex {{ $message->user_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[80%] {{ $message->user_id == Auth::id() ? 'bg-slate-900 text-white rounded-t-3xl rounded-bl-3xl shadow-xl shadow-slate-200' : 'bg-white text-slate-800 rounded-t-3xl rounded-br-3xl shadow-sm border border-slate-100' }} px-6 py-4">
                            <p class="font-medium text-sm leading-relaxed">{{ $message->body }}</p>
                            <span class="text-[9px] font-bold uppercase tracking-widest mt-2 block {{ $message->user_id == Auth::id() ? 'text-slate-400' : 'text-slate-300' }}">
                                {{ $message->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Chat Input -->
            <div class="p-6 bg-white border-t border-slate-50">
                <form action="{{ route('chat.store', $conversation->id) }}" method="POST" class="flex items-center gap-4">
                    @csrf
                    <input type="text" name="body" required placeholder="Type your message..." class="flex-1 px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-800 focus:ring-4 focus:ring-blue-500/20 transition-all placeholder:text-slate-300">
                    <button type="submit" class="bg-blue-600 text-white p-4 rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('message-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
