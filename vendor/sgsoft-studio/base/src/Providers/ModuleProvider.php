<?php namespace WebEd\Base\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Exceptions\Handler;
use WebEd\Base\Http\Middleware\StartSessionMiddleware;
use WebEd\Base\Support\Helper;

class ModuleProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //Load helpers
        Helper::loadModuleHelpers(__DIR__);

        $this->app->singleton(ExceptionHandler::class, Handler::class);

        //Merge configs
        $configs = split_files_with_basename($this->app['files']->glob(__DIR__ . '/../../config/*.php'));

        foreach ($configs as $key => $row) {
            $this->mergeConfigFrom($row, $key);
        }

        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', StartSessionMiddleware::class);

        /**
         * Base providers
         */
        $this->app->register(HookServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(MiddlewareServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ValidateServiceProvider::class);
        $this->app->register(ComposerServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(CollectiveServiceProvider::class);
        $this->app->register(BootstrapModuleServiceProvider::class);

        /**
         * Other module providers
         */
        $this->app->register(\WebEd\Base\Shortcode\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\Caching\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\ACL\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\ModulesManagement\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\AssetsManagement\Providers\ModuleProvider::class);

        $this->app->register(\WebEd\Base\Hook\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\Menu\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\Settings\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\ThemesManagement\Providers\ModuleProvider::class);
        $this->app->register(\WebEd\Base\Users\Providers\ModuleProvider::class);

        foreach (config('webed.external_core', []) as $item) {
            $this->app->register($item);
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*Load views*/
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'webed-core');
        /*Load translations*/
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'webed-core');

        $this->publishes([
            __DIR__ . '/../../resources/views' => config('view.paths')[0] . '/vendor/webed-core',
        ], 'views');
        $this->publishes([
            __DIR__ . '/../../resources/lang' => base_path('resources/lang/vendor/webed-core'),
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
}
