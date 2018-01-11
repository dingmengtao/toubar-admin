<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class UninstallModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'blog';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    protected function booted()
    {
        acl_permission()
            ->unsetPermissionByModule($this->moduleAlias);

        $this->dropSchema();
    }

    protected function dropSchema()
    {
        Schema::dropIfExists(webed_db_prefix() . 'posts_categories');
        Schema::dropIfExists(webed_db_prefix() . 'posts_tags');
        Schema::dropIfExists(webed_db_prefix() . 'tags');
        Schema::dropIfExists(webed_db_prefix() . 'posts');
        Schema::dropIfExists(webed_db_prefix() . 'categories');
        Schema::dropIfExists(webed_db_prefix() . 'cms_navigation');
    }
}
