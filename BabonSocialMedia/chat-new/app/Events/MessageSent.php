<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(): Channel|array
    {
        $sortedIds = [$this->message['sender_id'], $this->message['receiver_id']];
        sort($sortedIds);
        $channelName = 'messenger.' . $sortedIds[0] . '.' . $sortedIds[1];
        return new PrivateChannel($channelName);
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    public function broadcastWith(): array
    {
        $sender = User::find($this->message['sender_id']);
        $receiver = User::find($this->message['receiver_id']);
        return [
            'message' => $this->message,
            'sender_avatar' => $sender->avatar,
            'sender_username' => $sender->username,
            'receiver_avatar' => $receiver->avatar,
            'receiver_username' => $receiver->username,

        ];
    }
}
