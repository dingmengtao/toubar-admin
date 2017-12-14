<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 *
 * @var
 *
 */
Route::group(['prefix' => 'api'], function (Router $router) {
    /**
     * Front site
     */
    foreach (config('webed-pages.custom_route_locations.api', []) as $file) {
        require $file;
    }
    foreach (config('webed-pages.public_routes.api', []) as $method => $routeInfo) {
        foreach ($routeInfo as $item) {
            $router->$method($item[0], $item[1]);
        }
    }
});
