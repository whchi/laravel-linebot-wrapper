<?php

namespace App\Listeners;

use App\Events\SaveLineBotSessionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveLineBotSessionEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(SaveLineBotSessionEvent $event)
    {
        $sessionInstance = $event->instance->getSession($event->data);
        if ($sessionInstance) {
            $event->instance->modifyLastActivity($sessionInstance);
        } else {
            $event->instance->saveSession($event->data);
        }
    }
}
