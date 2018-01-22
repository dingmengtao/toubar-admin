<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-22
 * Time: 17:05
 */
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'wxtbuser'], function (Router $router) {
    $router->get('', 'WXTBUserController@getIndex')
        ->name('admin::miniprograms.toubar.user.index.get')
        ->middleware('has-permission:view-posts');

    $router->post('', 'WXTBUserController@postListing')
        ->name('admin::miniprograms.toubar.user.index.post')
        ->middleware('has-permission:view-posts');

    $router->get('create', 'WXTBUserController@getCreate')
        ->name('admin::miniprograms.toubar.user.create.get')
        ->middleware('has-permission:create-posts');

    $router->post('create', 'WXTBUserController@postCreate')
        ->name('admin::miniprograms.toubar.user.create.post')
        ->middleware('has-permission:create-posts');

    $router->get('edit/{id}', 'WXTBUserController@getEdit')
        ->name('admin::miniprograms.toubar.user.edit.get')
        ->middleware('has-permission:view-posts');

    $router->post('edit/{id}', 'WXTBUserController@postEdit')
        ->name('admin::miniprograms.toubar.user.edit.post')
        ->middleware('has-permission:update-posts');

    $router->post('update-status/{id}/{status}', 'WXTBUserController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.user.update-status.post')
        ->middleware('has-permission:update-posts');

    $router->post('delete/{id}', 'WXTBUserController@postDelete')
        ->name('admin::miniprograms.toubar.user.delete.post')
        ->middleware('has-permission:delete-posts');

    $router->post('force-delete/{id}', 'WXTBUserController@postForceDelete')
        ->name('admin::miniprograms.toubar.user.force-delete.post')
        ->middleware('has-permission:force-delete-posts');

    $router->post('restore/{id}', 'WXTBUserController@postRestore')
        ->name('admin::miniprograms.toubar.user.restore.post')
        ->middleware('has-permission:restore-deleted-posts');
});