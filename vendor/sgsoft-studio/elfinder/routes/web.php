<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

/**
 * Admin routes
 */
Route::group([
    'prefix' => $adminRoute . '/elfinder',
    'middleware' => 'has-permission:elfinder-view-files',
], function (Router $router) use ($adminRoute) {
    $router->get('', 'ElfinderController@getIndex')
        ->name('admin::elfinder.index.get');

    $router->get('/stand-alone', 'ElfinderController@getStandAlone')
        ->name('admin::elfinder.stand-alone.get');

    $router->get('/elfinder-view', 'ElfinderController@getElfinderView')
        ->name('admin::elfinder.popup.get');

    $router->any('/connector', 'ElfinderController@anyConnector')
        ->name('admin::elfinder.connect');
});
