<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Http\Middleware\AuthenticateAdmin;
use WebEd\Base\Users\Http\Middleware\AuthenticateFront;
use WebEd\Base\Users\Http\Middleware\GuestAdmin;
use WebEd\Base\Users\Http\Middleware\GuestFront;

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
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('webed.auth-admin', AuthenticateAdmin::class);
        $router->aliasMiddleware('webed.guest-admin', GuestAdmin::class);

        $router->aliasMiddleware('webed.auth-front', AuthenticateFront::class);
        $router->aliasMiddleware('webed.guest-front', GuestFront::class);

        if (is_admin_panel()) {
            $router->pushMiddlewareToGroup('web', AuthenticateAdmin::class);
        }
    }
}
