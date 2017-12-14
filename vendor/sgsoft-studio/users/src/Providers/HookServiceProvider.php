<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Hook\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(WEBED_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 24);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
