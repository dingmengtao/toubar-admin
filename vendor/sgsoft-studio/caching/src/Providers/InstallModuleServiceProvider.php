<?php namespace WebEd\Base\Caching\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_CACHING;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View cache management page', 'view-cache', $this->module)
            ->registerPermission('Modify cache', 'modify-cache', $this->module)
            ->registerPermission('Clear cache', 'clear-cache', $this->module);
    }
}
