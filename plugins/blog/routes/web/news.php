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

$router->group(['prefix' => 'news'], function (Router $router) {
    $router->get('', 'NewsController@getIndex')
        ->name('admin::blog.news.index.get');
//        ->middleware('has-permission:view-news');

    $router->post('', 'NewsController@postListing')
        ->name('admin::blog.news.index.post');
//        ->middleware('has-permission:view-posts');
//
    $router->get('create', 'NewsController@getCreate')
        ->name('admin::blog.news.create.get');
//        ->middleware('has-permission:create-posts');
//
    $router->post('create', 'NewsController@postCreate')
        ->name('admin::blog.news.create.post');
//        ->middleware('has-permission:create-posts');
//
    $router->get('edit/{id}', 'NewsController@getEdit')
        ->name('admin::blog.news.edit.get');
//        ->middleware('has-permission:view-posts');
//
    $router->post('edit/{id}', 'NewsController@postEdit')
        ->name('admin::blog.news.edit.post');
//        ->middleware('has-permission:update-posts');
//
    $router->post('update-status/{id}/{status}', 'NewsController@postUpdateStatus')
        ->name('admin::blog.news.update-status.post');
//        ->middleware('has-permission:update-posts');
//
    $router->post('delete/{id}', 'NewsController@postDelete')
        ->name('admin::blog.news.delete.post');
//        ->middleware('has-permission:delete-posts');
//
    $router->post('force-delete/{id}', 'NewsController@postForceDelete')
        ->name('admin::blog.news.force-delete.post');
//        ->middleware('has-permission:force-delete-posts');
//
    $router->post('restore/{id}', 'NewsController@postRestore')
        ->name('admin::blog.news.restore.post');
//        ->middleware('has-permission:restore-deleted-posts');

});
