<?php

namespace App\Events;

use App\Repositories\Sample\LineBotSessionRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaveLineBotSessionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * LINE event raw data
     *
     * @var array
     */
    public $data;

    /**
     * LineBotSessionRepository instance
     */
    public $instance;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->instance = new LineBotSessionRepository;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
