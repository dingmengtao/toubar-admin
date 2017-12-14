<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ThemesManagement\Hook\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(WEBED_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 23);
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
