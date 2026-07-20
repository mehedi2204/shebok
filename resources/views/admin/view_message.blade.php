@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.messages') }}" class="text-slate-500 hover:text-blue-600 font-bold text-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Messages
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex justify-between items-start">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">{{ $message->subject ?? 'No Subject' }}</h3>
                <div class="mt-2 flex items-center space-x-4 text-sm">
                    <span class="text-slate-500 font-bold">{{ $message->name }}</span>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-400 font-medium">{{ $message->email }}</span>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block">{{ $message->created_at->format('M d, Y') }}</span>
                <span class="text-xs font-medium text-slate-400 block">{{ $message->created_at->format('h:i A') }}</span>
            </div>
        </div>

        <div class="p-8">
            <div class="prose prose-slate max-w-none">
                <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $message->message }}</p>
            </div>
        </div>

        <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
            <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 font-bold text-sm hover:underline">Delete Message</button>
            </form>
            <a href="mailto:{{ $message->email }}" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200">Reply via Email</a>
        </div>
    </div>
</div>
@endsection
