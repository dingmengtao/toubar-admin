<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'WebEd\Base\Menu\Http\Controllers';

    public function boot()
    {
        $this->app->booted(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(__DIR__ . '/../../routes/web.php');
        });
    }
}
