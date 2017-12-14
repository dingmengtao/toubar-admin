<?php namespace WebEd\Base\AssetsManagement\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\AssetsManagement\Facades\AssetsFacade;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config' => base_path('config'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../resources/assets' => resource_path('assets'),
        ], 'webed-assets');
        $this->publishes([
            __DIR__ . '/../../resources/root' => base_path(),
            __DIR__ . '/../../resources/public' => public_path(),
        ], 'webed-public-assets');
    }

    public function register()
    {
        load_module_helpers(__DIR__);

        AliasLoader::getInstance()->alias('Assets', AssetsFacade::class);

        $this->mergeConfigFrom(__DIR__ . '/../../config/webed-assets.php', 'webed-assets');
    }
}
