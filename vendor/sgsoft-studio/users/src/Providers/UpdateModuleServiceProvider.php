<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = WEBED_USERS;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches($this->moduleAlias, [
            //'3.1.9' => __DIR__ . '/../../update-batches/3.1.9.php',
        ], 'core');

        load_module_update_batches($this->moduleAlias, 'core');
    }
}
