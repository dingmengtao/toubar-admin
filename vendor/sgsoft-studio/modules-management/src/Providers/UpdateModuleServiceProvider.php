<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches('webed-modules-management', [

        ], 'core');

        load_module_update_batches('webed-modules-management', 'core');
    }
}
