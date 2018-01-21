<?php
/**
 * Created by PhpStorm.
 * User: DingMengTao
 * Date: 2018/1/21
 * Time: 21:17
 */
use Illuminate\Routing\Router;

$router->group(['prefix' => 'toubar'], function (Router $router) {
    $router->get('', 'ToubarController@getIndex')
        ->name('admin::miniprograms.toubar.index.get');
    $router->post('', 'ToubarController@postListing')
        ->name('admin::miniprograms.toubar.index.post');

    $router->get('create', 'ToubarController@getCreate')
        ->name('admin::miniprograms.toubar.create.get');
    $router->post('create', 'ToubarController@postCreate')
        ->name('admin::miniprograms.toubar.create.post');

    $router->get('edit/{id}', 'ToubarController@getEdit')
        ->name('admin::miniprograms.toubar.edit.get');
    $router->post('edit/{id}', 'ToubarController@postEdit')
        ->name('admin::miniprograms.toubar.edit.post');

    $router->post('update-status/{id}/{status}', 'ToubarController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.update-status.post');

    $router->post('delete/{id}', 'ToubarController@postDelete')
        ->name('admin::miniprograms.toubar.delete.post');

    $router->post('force-delete/{id}', 'ToubarController@postForceDelete')
        ->name('admin::miniprograms.toubar.force-delete.post');

    $router->post('restore/{id}', 'ToubarController@postRestore')
        ->name('admin::miniprograms.toubar.restore.post');
});