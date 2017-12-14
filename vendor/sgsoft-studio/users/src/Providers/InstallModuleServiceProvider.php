<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_USERS;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View users', 'view-users', $this->module)
            ->registerPermission('Create users', 'create-users', $this->module)
            ->registerPermission('Edit other users', 'edit-other-users', $this->module)
            ->registerPermission('Delete users', 'delete-users', $this->module)
            ->registerPermission('Force delete users', 'force-delete-users', $this->module);
    }
}
