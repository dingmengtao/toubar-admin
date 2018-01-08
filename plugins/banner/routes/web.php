<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

$adminRoute = config('webed.admin_route');

$moduleRoute = 'banner';

Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    /**
     *
     * Put some route here
     *
     */

    Route::get('/banner', 'IndexController@getIndex')
        ->name('admin::banner.index.get');
});
