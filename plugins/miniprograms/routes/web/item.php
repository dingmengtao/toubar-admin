<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-22
 * Time: 17:04
 */
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'item'], function (Router $router) {
    $router->get('', 'ItemController@getIndex')
        ->name('admin::miniprograms.toubar.item.index.get')
        ->middleware('has-permission:view-posts');

    $router->post('', 'ItemController@postListing')
        ->name('admin::miniprograms.toubar.item.index.post')
        ->middleware('has-permission:view-posts');

    $router->get('create', 'ItemController@getCreate')
        ->name('admin::miniprograms.toubar.item.create.get')
        ->middleware('has-permission:create-posts');

    $router->post('create', 'ItemController@postCreate')
        ->name('admin::miniprograms.toubar.item.create.post')
        ->middleware('has-permission:create-posts');

    $router->get('edit/{id}', 'ItemController@getEdit')
        ->name('admin::miniprograms.toubar.item.edit.get')
        ->middleware('has-permission:view-posts');

    $router->post('edit/{id}', 'ItemController@postEdit')
        ->name('admin::miniprograms.toubar.item.edit.post')
        ->middleware('has-permission:update-posts');

    $router->post('update-status/{id}/{status}', 'ItemController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.item.update-status.post')
        ->middleware('has-permission:update-posts');

    $router->post('delete/{id}', 'ItemController@postDelete')
        ->name('admin::miniprograms.toubar.item.delete.post')
        ->middleware('has-permission:delete-posts');

    $router->post('force-delete/{id}', 'ItemController@postForceDelete')
        ->name('admin::miniprograms.toubar.item.force-delete.post')
        ->middleware('has-permission:force-delete-posts');

    $router->post('restore/{id}', 'ItemController@postRestore')
        ->name('admin::miniprograms.toubar.item.restore.post')
        ->middleware('has-permission:restore-deleted-posts');
});