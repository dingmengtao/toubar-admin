<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018-01-22
 * Time: 17:03
 */
use Illuminate\Routing\Router;

/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'investor'], function (Router $router) {
    $router->get('', 'InvestorController@getIndex')
        ->name('admin::miniprograms.toubar.investor.index.get')
        ->middleware('has-permission:view-investor');

    $router->post('', 'InvestorController@postListing')
        ->name('admin::miniprograms.toubar.investor.index.post')
        ->middleware('has-permission:view-investor');

    $router->get('create', 'InvestorController@getCreate')
        ->name('admin::miniprograms.toubar.investor.create.get')
        ->middleware('has-permission:create-investor');

    $router->post('create', 'InvestorController@postCreate')
        ->name('admin::miniprograms.toubar.investor.create.post')
        ->middleware('has-permission:create-investor');

    $router->get('edit/{id}', 'InvestorController@getEdit')
        ->name('admin::miniprograms.toubar.investor.edit.get')
        ->middleware('has-permission:view-investor');

    $router->post('edit/{id}', 'InvestorController@postEdit')
        ->name('admin::miniprograms.toubar.investor.edit.post')
        ->middleware('has-permission:update-investor');

    $router->post('update-status/{id}/{status}', 'InvestorController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.investor.update-status.post')
        ->middleware('has-permission:update-investor');

    $router->post('delete/{id}', 'InvestorController@postDelete')
        ->name('admin::miniprograms.toubar.investor.delete.post')
        ->middleware('has-permission:delete-investor');

    $router->post('force-delete/{id}', 'InvestorController@postForceDelete')
        ->name('admin::miniprograms.toubar.investor.force-delete.post')
        ->middleware('has-permission:force-delete-investor');

    $router->post('restore/{id}', 'InvestorController@postRestore')
        ->name('admin::miniprograms.toubar.investor.restore.post')
        ->middleware('has-permission:restore-deleted-investor');
});