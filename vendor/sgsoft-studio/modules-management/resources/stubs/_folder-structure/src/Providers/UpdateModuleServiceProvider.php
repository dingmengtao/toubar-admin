<?php namespace DummyNamespace\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $moduleAlias = 'DummyAlias';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches($this->moduleAlias, [
            //'2.1.4' => __DIR__ . '/../../update-batches/2.1.4.php',
        ], 'DummyType');

        load_module_update_batches($this->moduleAlias, 'DummyType');
    }
}
