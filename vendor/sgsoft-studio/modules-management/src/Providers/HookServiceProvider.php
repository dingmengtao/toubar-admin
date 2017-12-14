<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ModulesManagement\Hook\RegisterDashboardStats;
use WebEd\Base\ModulesManagement\Hook\ShowCmsUpdateNotification;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(WEBED_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 22);
        add_action(BASE_ACTION_FLASH_MESSAGES, [ShowCmsUpdateNotification::class, 'handle', 9]);
    }
}
