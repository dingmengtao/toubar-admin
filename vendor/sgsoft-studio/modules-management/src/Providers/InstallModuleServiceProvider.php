<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_MODULES_MANAGEMENT;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View plugins', 'view-plugins', $this->module);
    }
}
