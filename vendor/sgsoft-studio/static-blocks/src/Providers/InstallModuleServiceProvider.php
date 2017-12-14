<?php namespace WebEd\Base\StaticBlocks\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Database\Schema\Blueprint;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = WEBED_STATIC_BLOCKS;
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View static blocks', 'view-static-blocks', $this->moduleAlias)
            ->registerPermission('Create static blocks', 'create-static-blocks', $this->moduleAlias)
            ->registerPermission('Edit static blocks', 'update-static-blocks', $this->moduleAlias)
            ->registerPermission('Delete static blocks', 'delete-static-blocks', $this->moduleAlias);
    }
}
