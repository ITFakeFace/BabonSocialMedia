<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderId;
    public $receiverId;
    public $isTyping;

    /**
     * Create a new event instance.
     *
     * @param int $senderId
     * @param int $receiverId
     * @param bool $isTyping
     * @return void
     */
    public function __construct($senderId, $receiverId, $isTyping)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->isTyping = $isTyping;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): \Illuminate\Broadcasting\Channel|PrivateChannel|array
    {
        $sortedIds = [$this->senderId ,  $this->receiverId ];
        sort($sortedIds);
        $channelName = 'messenger.' . $sortedIds[0] . '.' . $sortedIds[1];
        return new PrivateChannel($channelName);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'typing';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'senderId' => $this->senderId,
            'receiverId' => $this->receiverId,
            'isTyping' => $this->isTyping,
        ];
    }
}
