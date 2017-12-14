<?php

namespace WebEd\Base\Users\Listeners;

use Illuminate\Auth\Events\Logout;

class UserLoggedOutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $event;

    /**
     * Handle the event.
     *
     * @param  Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $this->event = $event;

        session(['lastLoggedIn' => null]);
    }
}
