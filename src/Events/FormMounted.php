<?php

namespace LaraZeus\Bolt\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormMounted
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('form-mounted');
    }
}
