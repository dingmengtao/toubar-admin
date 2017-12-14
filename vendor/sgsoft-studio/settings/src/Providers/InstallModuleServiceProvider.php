<?php namespace WebEd\Base\Settings\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_SETTINGS;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View settings page', 'view-settings', $this->module)
            ->registerPermission('Edit settings', 'edit-settings', $this->module);
    }
}
