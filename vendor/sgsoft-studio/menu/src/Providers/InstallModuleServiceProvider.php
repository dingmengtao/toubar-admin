<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_MENUS;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View menus', 'view-menus', $this->module)
            ->registerPermission('Delete menus', 'delete-menus', $this->module)
            ->registerPermission('Create menus', 'create-menus', $this->module)
            ->registerPermission('Edit menus', 'edit-menus', $this->module);
    }
}
