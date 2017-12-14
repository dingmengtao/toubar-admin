<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

$adminRoute = config('webed.admin_route');

$moduleRoute = 'static-blocks';

Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('/', 'StaticBlockController@getIndex')
        ->name('admin::static-blocks.index.get')
        ->middleware('has-permission:view-static-blocks');

    $router->post('/', 'StaticBlockController@postListing')
        ->name('admin::static-blocks.index.post')
        ->middleware('has-permission:view-static-blocks');

    $router->post('update-status/{id}/{status}', 'StaticBlockController@postUpdateStatus')
        ->name('admin::static-blocks.update-status.post')
        ->middleware('has-permission:edit-static-blocks');

    $router->get('create', 'StaticBlockController@getCreate')
        ->name('admin::static-blocks.create.get')
        ->middleware('has-permission:create-static-blocks');

    $router->post('create', 'StaticBlockController@postCreate')
        ->name('admin::static-blocks.create.post')
        ->middleware('has-permission:create-static-blocks');

    $router->get('edit/{id}', 'StaticBlockController@getEdit')
        ->name('admin::static-blocks.edit.get')
        ->middleware('has-permission:view-static-blocks');

    $router->post('edit/{id}', 'StaticBlockController@postEdit')
        ->name('admin::static-blocks.edit.post')
        ->middleware('has-permission:update-static-blocks');

    $router->post('/{id}', 'StaticBlockController@postDelete')
        ->name('admin::static-blocks.delete.post')
        ->middleware('has-permission:delete-static-blocks');
});
