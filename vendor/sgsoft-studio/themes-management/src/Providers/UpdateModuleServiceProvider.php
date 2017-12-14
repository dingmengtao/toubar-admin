<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $module = WEBED_THEMES_MANAGEMENT;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches($this->module, [

        ], 'core');

        load_module_update_batches($this->module, 'core');
    }
}
