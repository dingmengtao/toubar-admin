<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Menu\Hook\InsertNoticesToUpdateMenuPageHook;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(BASE_ACTION_FLASH_MESSAGES, [InsertNoticesToUpdateMenuPageHook::class, 'execute'], 18);
    }
}
