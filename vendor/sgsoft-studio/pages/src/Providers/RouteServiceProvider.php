<?php

namespace WebEd\Base\Pages\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(__DIR__ . '/../../routes/web.php');

            Route::prefix(config('webed.api_route', 'api'))
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(__DIR__ . '/../../routes/api.php');
        });
    }
}
