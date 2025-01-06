<?php

namespace App\Http\Controllers\Web\Backend\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = ChatMessage::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'text' => $request->message,
            'conversation_id' => $request->conversation_id,
        ]);

        // Broadcast the message event
        broadcast(new MessageSent($message));

        return response()->json($message, 200);
    }

    public function getMessages($conversation_id)
    {
        $messages = ChatMessage::where('conversation_id', $conversation_id)->get();
        return response()->json($messages, 200);
    }
}
