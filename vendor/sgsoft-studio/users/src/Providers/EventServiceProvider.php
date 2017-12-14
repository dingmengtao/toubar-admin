<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Listeners\UserLoggedInListener;
use WebEd\Base\Users\Listeners\UserLoggedOutListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen('Illuminate\Auth\Events\Login', UserLoggedInListener::class);
        Event::listen('Illuminate\Auth\Events\Logout', UserLoggedOutListener::class);
    }
}
