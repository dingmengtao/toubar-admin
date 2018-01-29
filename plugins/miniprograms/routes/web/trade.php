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

$router->group(['prefix' => 'trade'], function (Router $router) {
    $router->get('', 'TradeController@getIndex')
        ->name('admin::miniprograms.toubar.trade.index.get')
        ->middleware('has-permission:view-trade');

    $router->post('', 'TradeController@postListing')
        ->name('admin::miniprograms.toubar.trade.index.post')
        ->middleware('has-permission:view-trade');

    $router->get('create', 'TradeController@getCreate')
        ->name('admin::miniprograms.toubar.trade.create.get')
        ->middleware('has-permission:create-trade');

    $router->post('create', 'TradeController@postCreate')
        ->name('admin::miniprograms.toubar.trade.create.post')
        ->middleware('has-permission:create-trade');

    $router->get('edit/{id}', 'TradeController@getEdit')
        ->name('admin::miniprograms.toubar.trade.edit.get')
        ->middleware('has-permission:view-trade');

    $router->post('edit/{id}', 'TradeController@postEdit')
        ->name('admin::miniprograms.toubar.trade.edit.post')
        ->middleware('has-permission:update-trade');

    $router->post('update-status/{id}/{status}', 'TradeController@postUpdateStatus')
        ->name('admin::miniprograms.toubar.trade.update-status.post')
        ->middleware('has-permission:update-trade');

    $router->post('delete/{id}', 'TradeController@postDelete')
        ->name('admin::miniprograms.toubar.trade.delete.post')
        ->middleware('has-permission:delete-trade');

    $router->post('force-delete/{id}', 'TradeController@postForceDelete')
        ->name('admin::miniprograms.toubar.trade.force-delete.post')
        ->middleware('has-permission:force-delete-trade');

    $router->post('restore/{id}', 'TradeController@postRestore')
        ->name('admin::miniprograms.toubar.trade.restore.post')
        ->middleware('has-permission:restore-deleted-trade');
});