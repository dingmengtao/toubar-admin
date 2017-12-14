<?php namespace WebEd\Base\Elfinder\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_ELFINDER;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        acl_permission()
            ->registerPermission('View files', 'elfinder-view-files', $this->module);
    }
}
