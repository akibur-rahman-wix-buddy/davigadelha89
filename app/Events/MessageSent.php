<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct( ChatMessage $message )
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("chat.{$this->message->receiver_id}"),
        ];
    }



     /**
     * Get the broadcast data.
     *
     * @return array
     */
    // public function broadcastWith()
    // {
    //     return [
    //         'sender_id' => $this->message->sender_id,
    //         'receiver_id' => $this->message->receiver_id,
    //         'text' => $this->message->text,
    //         'created_at' => $this->message->created_at,
    //     ];
    // }



    public function broadcastWith()
    {
        return ['message' => $this->message];
    }


}
