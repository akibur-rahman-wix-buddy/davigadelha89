<?php

namespace App\Http\Controllers\Api;

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
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message, 200);
    }

    public function getMessages($conversation_id)
    {
        $messages = ChatMessage::where('conversation_id', $conversation_id)->get();
        return response()->json($messages, 200);
    }
}


