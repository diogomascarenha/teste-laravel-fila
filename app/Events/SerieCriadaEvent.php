<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Serie;

class SerieCriadaEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Serie
     */
    public $serie;

    /**
     * @var User
     */
    public $usuario;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Serie $serie, User $usuario)
    {
        $this->serie   = $serie;
        $this->usuario = $usuario;
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
