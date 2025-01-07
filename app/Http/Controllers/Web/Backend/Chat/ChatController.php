<?php

namespace App\Http\Controllers\Web\Backend\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // public function sendMessage(Request $request)
    // {
    //     $message = ChatMessage::create([
    //         // 'sender_id' => $request->sender_id,
    //         'sender_id' => auth()->id(),
    //         'receiver_id' => $request->receiver_id,
    //         'text' => $request->message,
    //         // 'conversation_id' => $request->conversation_id,
    //     ]);

    //     //! Broadcast the message event
    //     broadcast(new MessageSent($message));

    //     // return response()->json($message, 200);
    //     return view('backend.layouts.chat.sendMessage', compact('message'));
    // }








    public function sendMessage(Request $request)
    {
        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'text' => $request->message,
        ]);

        $messages = ChatMessage::where(function ($query) use ($request) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $request->receiver_id);
        })
            ->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->receiver_id)
                    ->where('receiver_id', auth()->id());
            })
            ->get();

        broadcast(new MessageSent($message));

        return view('backend.layouts.chat.sendMessage', compact('message', 'messages'))->with('receiver_id', $request->receiver_id);
    }









    // public function getMessages($conversation_id)
    // {
    //     $messages = ChatMessage::where('conversation_id', $conversation_id)->get();
    //     return response()->json($messages, 200);
    // }



    public function showChatForm(User $user)
    {
        $users = User::all();

        $messages = ChatMessage::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', auth()->id());
            })
            ->get();

        return view('backend.layouts.chat.sendMessage', compact('messages', 'users', 'user'))  // 'user' পাঠানো হলো
            ->with('receiver_id', $user->id);
    }
}
