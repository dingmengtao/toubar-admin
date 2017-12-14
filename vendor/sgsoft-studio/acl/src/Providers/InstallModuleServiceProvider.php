<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'webed-acl';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View roles', 'view-roles', $this->module)
            ->registerPermission('Create roles', 'create-roles', $this->module)
            ->registerPermission('Edit roles', 'edit-roles', $this->module)
            ->registerPermission('Delete roles', 'delete-roles', $this->module)
            ->registerPermission('View permissions', 'view-permissions', $this->module)
            ->registerPermission('Assign roles', 'assign-roles', $this->module);
    }
}
