<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'tags'], function (Router $router) {
    $router->get('', 'BlogTagController@getIndex')
        ->name('admin::blog.tags.index.get')
        ->middleware('has-permission:view-tags');

    $router->post('', 'BlogTagController@postListing')
        ->name('admin::blog.tags.index.post')
        ->middleware('has-permission:view-tags');

    $router->get('create', 'BlogTagController@getCreate')
        ->name('admin::blog.tags.create.get')
        ->middleware('has-permission:create-tags');

    $router->post('create', 'BlogTagController@postCreate')
        ->name('admin::blog.tags.create.post')
        ->middleware('has-permission:create-tags');

    $router->get('edit/{id}', 'BlogTagController@getEdit')
        ->name('admin::blog.tags.edit.get')
        ->middleware('has-permission:view-tags');

    $router->post('edit/{id}', 'BlogTagController@postEdit')
        ->name('admin::blog.tags.edit.post')
        ->middleware('has-permission:update-tags');

    $router->post('update-status/{id}/{status}', 'BlogTagController@postUpdateStatus')
        ->name('admin::blog.tags.update-status.post')
        ->middleware('has-permission:update-tags');

    $router->post('delete/{id}', 'BlogTagController@postDelete')
        ->name('admin::blog.tags.delete.post')
        ->middleware('has-permission:delete-tags');

    $router->post('force-delete/{id}', 'BlogTagController@postForceDelete')
        ->name('admin::blog.tags.force-delete.post')
        ->middleware('has-permission:force-delete-tags');

    $router->post('restore/{id}', 'BlogTagController@postRestore')
        ->name('admin::blog.tags.restore.post')
        ->middleware('has-permission:restore-deleted-tags');
});
