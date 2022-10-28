<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fullMessage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($full_message)
    {
        $this->fullMessage = $full_message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return string[]
     */
    public function broadcastOn()
    {
        log::info(111);
//        return new Channel('chat');
        return ['chat'];
    }

    public function broadcastAs()
    {
        log::info(222);
        return 'message';
    }
}
