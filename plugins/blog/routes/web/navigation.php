<?php
/**
 * Created by PhpStorm.
 * User: Zhupe
 * Date: 2018/1/9
 * Time: 16:36
 */

use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'navigation'], function (Router $router) {
    $router->get('/', 'NavigationController@getIndex')
        ->name('admin::navigation.index.get');
//        ->middleware('has-permission:view-news');

    $router->post('/', 'NavigationController@postListing')
        ->name('admin::blog.navigation.index.post');


//
    $router->get('create', 'NavigationController@getCreate')
        ->name('admin::blog.navigation.create.get');
//        ->middleware('has-permission:create-posts');

    $router->post('create', 'NavigationController@postCreate')
        ->name('admin::blog.navigation.create.post')
        ;
//        ->middleware('has-permission:create-posts');

    $router->get('edit/{id}', 'NavigationController@getEdit')
        ->name('admin::blog.navigation.edit.get')
        ;
//        ->middleware('has-permission:view-posts');

    $router->post('edit/{id}', 'NavigationController@postEdit')
        ->name('admin::blog.navigation.edit.post')
        ;
//        ->middleware('has-permission:update-posts');

    $router->post('update-status/{id}/{status}', 'NavigationController@postUpdateStatus')
        ->name('admin::blog.navigation.update-status.post')
        ;
//        ->middleware('has-permission:update-posts');

    $router->post('delete/{id}', 'NavigationController@postDelete')
        ->name('admin::blog.navigation.delete.post')
        ;
//        ->middleware('has-permission:delete-posts');

    $router->post('force-delete/{id}', 'NavigationController@postForceDelete')
        ->name('admin::blog.navigation.force-delete.post')
        ;
//        ->middleware('has-permission:force-delete-posts');

    $router->post('restore/{id}', 'NavigationController@postRestore')
        ->name('admin::blog.navigation.restore.post')
        ;
//        ->middleware('has-permission:restore-deleted-posts');
});
