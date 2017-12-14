<?php namespace WebEd\Base\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = WEBED_PAGES;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View pages', 'view-pages', $this->moduleAlias)
            ->registerPermission('Create pages', 'create-pages', $this->moduleAlias)
            ->registerPermission('Edit pages', 'edit-pages', $this->moduleAlias)
            ->registerPermission('Delete pages', 'delete-pages', $this->moduleAlias)
            ->registerPermission('Restore deleted pages', 'restore-deleted-pages', $this->moduleAlias)
            ->registerPermission('Delete pages permanently', 'force-delete-pages', $this->moduleAlias);
    }
}
