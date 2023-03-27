<?php

namespace App\Events;

use App\Models\Os;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AtualizacaoOrdem implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Os $ordem;

    public function __construct(Os $ordem)
    {
        $this->ordem = $ordem;
    }

    public function broadcastOn()
    {
        return new Channel('atualizacao-ordem');
    }

    public function broadcastAs()
    {
        return 'alteracao-status';
    }
}
