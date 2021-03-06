<?php namespace WebEd\Plugins\Banner\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class UninstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'banner';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->unsetPermissionByModule($this->moduleAlias);

        $this->dropSchema();
    }

    protected function dropSchema()
    {
        Schema::dropIfExists(webed_db_prefix() .'banner');
    }
}
