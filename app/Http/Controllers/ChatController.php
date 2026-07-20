<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver', 'latestMessage'])
            ->get();

        return view('user.chat', compact('conversations'));
    }

    public function show($id)
    {
        $conversation = Conversation::where(function($q) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->with(['sender', 'receiver', 'messages.user'])
            ->findOrFail($id);

        // Mark messages as read
        $conversation->messages()->where('user_id', '!=', Auth::id())->update(['is_read' => true]);

        return view('user.chat_show', compact('conversation'));
    }

    public function store(Request $request, $id)
    {
        $request->validate(['body' => 'required|string']);

        $conversation = Conversation::where(function($q) {
                $q->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->findOrFail($id);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return back();
    }

    public function start(Request $request, $receiverId)
    {
        if ($receiverId == Auth::id()) {
            return back()->with('error', 'You cannot message yourself.');
        }

        $conversation = Conversation::where(function($q) use ($receiverId) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $receiverId);
            })
            ->orWhere(function($q) use ($receiverId) {
                $q->where('sender_id', $receiverId)->where('receiver_id', Auth::id());
            })
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
            ]);
        }

        return redirect()->route('chat.show', $conversation->id);
    }
}
