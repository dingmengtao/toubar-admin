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

$router->group(['prefix' => 'stage'], function (Router $router) {
    $router->get('', 'StageController@getIndex')
        ->name('admin::miniprograms.toubar.stage.index.get')
        ->middleware('has-permission:view-stage');

    $router->post('', 'StageController@postListing')
        ->name('admin::miniprograms.toubar.stage.index.post')
        ->middleware('has-permission:view-stage');

    $router->get('create', 'StageController@getCreate')
        ->name('admin::miniprograms.toubar.stage.create.get')
        ->middleware('has-permission:create-stage');

    $router->post('create', 'StageController@postCreate')
        ->name('admin::miniprograms.toubar.stage.create.post')
        ->middleware('has-permission:create-stage');

    $router->get('edit/{id}', 'StageController@getEdit')
        ->name('admin::miniprograms.toubar.stage.edit.get')
        ->middleware('has-permission:view-stage');

    $router->post('edit/{id}', 'StageController@postEdit')
        ->name('admin::miniprograms.toubar.stage.edit.post')
        ->middleware('has-permission:update-stage');

    $router->post('update-status/{id}/{status}', 'StageController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.stage.update-status.post')
        ->middleware('has-permission:update-stage');

    $router->post('delete/{id}', 'StageController@postDelete')
        ->name('admin::miniprograms.toubar.stage.delete.post')
        ->middleware('has-permission:delete-stage');

    $router->post('force-delete/{id}', 'StageController@postForceDelete')
        ->name('admin::miniprograms.toubar.stage.force-delete.post')
        ->middleware('has-permission:force-delete-stage');

    $router->post('restore/{id}', 'StageController@postRestore')
        ->name('admin::miniprograms.toubar.stage.restore.post')
        ->middleware('has-permission:restore-deleted-stage');
});