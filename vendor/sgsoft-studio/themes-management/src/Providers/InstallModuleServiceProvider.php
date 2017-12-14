<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_THEMES_MANAGEMENT;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View themes', 'view-themes', $this->module)
            ->registerPermission('View theme options', 'view-theme-options', $this->module)
            ->registerPermission('Update theme options', 'update-theme-options', $this->module);
    }
}
