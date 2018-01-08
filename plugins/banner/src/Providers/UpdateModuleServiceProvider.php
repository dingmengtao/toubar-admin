<?php namespace WebEd\Plugins\Banner\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'banner';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches($this->moduleAlias, [
            //'2.1.4' => __DIR__ . '/../../update-batches/2.1.4.php',
        ], 'plugins');

        load_module_update_batches($this->moduleAlias, 'plugins');
    }
}
