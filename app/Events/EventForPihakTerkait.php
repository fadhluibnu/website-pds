<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventForPihakTerkait implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pihak_terkait;
    public $identitas;
    public $id;
    // public $badge;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pt, $identitas, $id)
    {
        $this->pihak_terkait = $pt;
        $this->identitas = $identitas;
        $this->id = $id;
        // $this->badge = $badge;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('for_pihak_terkait');
    }
}
