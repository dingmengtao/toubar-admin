<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'categories'], function (Router $router) {
    $router->get('', 'CategoryController@getIndex')
        ->name('admin::blog.categories.index.get')
        ->middleware('has-permission:view-categories');

    $router->post('', 'CategoryController@postListing')
        ->name('admin::blog.categories.index.post')
        ->middleware('has-permission:view-categories');

    $router->get('create', 'CategoryController@getCreate')
        ->name('admin::blog.categories.create.get')
        ->middleware('has-permission:create-categories');

    $router->post('create', 'CategoryController@postCreate')
        ->name('admin::blog.categories.create.post')
        ->middleware('has-permission:create-categories');

    $router->get('edit/{id}', 'CategoryController@getEdit')
        ->name('admin::blog.categories.edit.get')
        ->middleware('has-permission:view-categories');

    $router->post('edit/{id}', 'CategoryController@postEdit')
        ->name('admin::blog.categories.edit.post')
        ->middleware('has-permission:update-categories');

    $router->post('update-status/{id}/{status}', 'CategoryController@postUpdateStatus')
        ->name('admin::blog.categories.update-status.post')
        ->middleware('has-permission:update-categories');

    $router->post('delete/{id}', 'CategoryController@postDelete')
        ->name('admin::blog.categories.delete.post')
        ->middleware('has-permission:delete-categories');

    $router->post('force-delete/{id}', 'CategoryController@postForceDelete')
        ->name('admin::blog.categories.force-delete.post')
        ->middleware('has-permission:force-delete-categories');

    $router->post('restore/{id}', 'CategoryController@postRestore')
        ->name('admin::blog.categories.restore.post')
        ->middleware('has-permission:restore-deleted-categories');
});
