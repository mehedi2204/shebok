@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-xl font-bold text-slate-800">Messages</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">From</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Subject</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($messages as $message)
                <tr class="hover:bg-slate-50/50 transition-colors {{ !$message->is_read ? 'font-bold' : '' }}">
                    <td class="px-6 py-4">
                        @if(!$message->is_read)
                            <span class="w-2.5 h-2.5 bg-blue-600 rounded-full inline-block" title="Unread"></span>
                        @else
                            <span class="w-2.5 h-2.5 bg-slate-200 rounded-full inline-block" title="Read"></span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-800">{{ $message->name }}</div>
                        <div class="text-xs text-slate-400">{{ $message->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ Str::limit($message->subject ?? 'No Subject', 40) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $message->created_at->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.messages.show', $message->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg font-bold text-xs hover:bg-blue-100 transition">View</a>
                        <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-100 transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">No messages found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($messages->hasPages())
    <div class="p-6 border-t border-slate-50">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
