<?php namespace WebEd\Base\Shortcode\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Shortcode\Compilers\ShortcodeCompiler;
use WebEd\Base\Shortcode\Facades\ShortcodeFacade;
use WebEd\Base\Shortcode\Support\Shortcode;

class ModuleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-shortcode');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-shortcode');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-shortcode',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-shortcode'),
        ], 'lang');
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

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        load_module_helpers(__DIR__);

        //Merge configs
        $configs = split_files_with_basename($this->app['files']->glob(__DIR__ . '/../../config/*.php'));

        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }

        $this->registerShortcode();
    }

    protected function registerShortcode()
    {
        /**
         * Register shortcode
         */
        $this->app->singleton('shortcode.compiler', function ($app) {
            return new ShortcodeCompiler();
        });
        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });

        /**
         * Register shortcode alias
         */
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Shortcode', ShortcodeFacade::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'shortcode',
            'shortcode.compiler',
        ];
    }
}
