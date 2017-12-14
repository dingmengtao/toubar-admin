<?php namespace WebEd\Base\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Pages\Hook\Actions\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action(WEBED_DASHBOARD_STATS, [RegisterDashboardStats::class, 'handle'], 21);
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
