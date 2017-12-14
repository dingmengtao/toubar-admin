<?php
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'posts'], function (Router $router) {
    $router->get('', 'PostController@getIndex')
        ->name('admin::blog.posts.index.get')
        ->middleware('has-permission:view-posts');

    $router->post('', 'PostController@postListing')
        ->name('admin::blog.posts.index.post')
        ->middleware('has-permission:view-posts');

    $router->get('create', 'PostController@getCreate')
        ->name('admin::blog.posts.create.get')
        ->middleware('has-permission:create-posts');

    $router->post('create', 'PostController@postCreate')
        ->name('admin::blog.posts.create.post')
        ->middleware('has-permission:create-posts');

    $router->get('edit/{id}', 'PostController@getEdit')
        ->name('admin::blog.posts.edit.get')
        ->middleware('has-permission:view-posts');

    $router->post('edit/{id}', 'PostController@postEdit')
        ->name('admin::blog.posts.edit.post')
        ->middleware('has-permission:update-posts');

    $router->post('update-status/{id}/{status}', 'PostController@postUpdateStatus')
        ->name('admin::blog.posts.update-status.post')
        ->middleware('has-permission:update-posts');

    $router->post('delete/{id}', 'PostController@postDelete')
        ->name('admin::blog.posts.delete.post')
        ->middleware('has-permission:delete-posts');

    $router->post('force-delete/{id}', 'PostController@postForceDelete')
        ->name('admin::blog.posts.force-delete.post')
        ->middleware('has-permission:force-delete-posts');

    $router->post('restore/{id}', 'PostController@postRestore')
        ->name('admin::blog.posts.restore.post')
        ->middleware('has-permission:restore-deleted-posts');
});
