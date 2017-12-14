<?php

namespace WebEd\Base\Users\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class UserLoggedInListener
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
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $this->event = $event;

        $this->_updateLastLoggedIn();
    }

    /**
     * Update last logged in
     */
    protected function _updateLastLoggedIn()
    {
        $user = $this->event->user;
        session(['lastLoggedIn' => $user->last_logged_in]);
        $user->last_login_at = Carbon::now();
        $user->save();
    }
}
