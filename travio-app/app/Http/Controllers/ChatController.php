<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $chats = $user->chats;

        return view('chattb', compact('chats'));
    }
    public function show(Chat $chat)
    {

        abort_unless(
            $chat->users()->where('user_id', auth()->id())->exists(),
            403,
            'You are not a member of this chat.'
        );


        $chat->load(['users', 'messages.user']);


        $myChats = Chat::whereHas('users', function ($q) {
            $q->where('user_id', auth()->id());
        })->with(['users', 'messages.user'])->get();

        return view('chattb', [
            'chats'      => $myChats,
            'activeChat' => $chat,
        ]);
    }
    public function messages(Chat $chat)
    {
        $messages = Message::with('user')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($messages);
    }
    public function sendMessage(Request $request, Chat $chat)
    {
        abort_unless(
            $chat->users()->where('user_id', auth()->id())->exists(),
            403,
            'You are not a member of this chat.'
        );

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $message = $chat->messages()->create([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'body'    => $data['body'],
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()->route('chats.show', $chat)
            ->with('success', 'Message sent.');
    }
}
