<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\ACL\Http\Middleware\HasPermission;
use WebEd\Base\ACL\Http\Middleware\HasRole;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * @var  Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('has-role', HasRole::class);
        $router->aliasMiddleware('has-permission', HasPermission::class);
    }
}
