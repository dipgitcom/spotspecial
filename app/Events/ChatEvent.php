<?php

namespace App\Events;

use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ChatEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels, InteractsWithSockets;

    public $chat;
    /**
     * Create a new event instance.
     */
    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        Log::info('enter broadcats');
        return new PrivateChannel('chat-conversation.' . $this->chat->conversation_id);
    }

    public function broadcastWith()
{
    return [
        'id'            => $this->chat->id,
        'message'       => $this->chat->message,
        'sender_id'     => $this->chat->sender_id,
        'receiver_id'   => $this->chat->receiver_id,
        'created_at'    => $this->chat->created_at->toDateTimeString(),
        'is_read'       => $this->chat->is_read,
        'message_status'=> $this->chat->message_status,
        'conversation_id'=> $this->chat->conversation_id,
    ];
}

}
