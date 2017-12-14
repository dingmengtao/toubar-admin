<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;

class UpdateModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Plugins\Blog';

    protected $moduleAlias = 'webed-blog';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        register_module_update_batches($this->moduleAlias, [
            //'3.1.1' => __DIR__ . '/../../update-batches/3.1.1.php',
        ]);
    }

    protected function booted()
    {
        load_module_update_batches($this->moduleAlias);
    }
}
