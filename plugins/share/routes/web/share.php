<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-09
 * Time: 10:22
 */

//use think\Route;
//
//Route::group(['prefix' => 'share'],function (){
//    Route::get('list','ShareController@getIndex')->name('admin::share.share.index.get');
//    Route::post('list','ShareController@postListing')->name('admin::share.share.index.post');
//
//    Route::get('create','ShareController@getCreate')->name('admin::share.share.create.get');
//    Route::post('create','ShareController@postCreate')->name('admin::share.share.create.post');
//
//    Route::get('edit/{id}','ShareController@editShare')->name('admin::share.share.editshare.get');
//    Route::post('edit/{id}','ShareController@editShare')->name('admin::share.share.editshare.get');
//
//    Route::post('update/{id}','ShareController@updateShare')->name('admin::share.share.updateshare.post');
//    Route::get('delete/{id}','ShareController@deleteShare')->name('admin::share.share.deleteshare.get');
//});

use Illuminate\Routing\Router;

$router->group(['prefix' => 'share'], function (Router $router) {
    $router->get('', 'ShareController@getIndex')
        ->name('admin::share.share.index.get');
    $router->post('', 'ShareController@postListing')
        ->name('admin::share.share.index.post');

    $router->get('create', 'ShareController@getCreate')
        ->name('admin::share.share.create.get');
    $router->post('create', 'ShareController@postCreate')
        ->name('admin::share.share.create.post');

    $router->get('edit/{id}', 'ShareController@getEdit')
        ->name('admin::share.share.edit.get');
    $router->post('edit/{id}', 'ShareController@postEdit')
        ->name('admin::share.share.edit.post');

    $router->post('update-status/{id}/{status}', 'ShareController@postUpdateStatus')
        ->name('admin::share.share.update-status.post');

    $router->post('delete/{id}', 'ShareController@postDelete')
        ->name('admin::share.share.delete.post');

    $router->post('force-delete/{id}', 'ShareController@postForceDelete')
        ->name('admin::share.share.force-delete.post');

    $router->post('restore/{id}', 'ShareController@postRestore')
        ->name('admin::share.share.restore.post');
});
