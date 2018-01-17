<?php
/**
 * Created by PhpStorm.
 * User: Zhupe
 * Date: 2018/1/16
 * Time: 13:57
 */
use Illuminate\Routing\Router;


/**
 *
 * @var Router $router
 *
 */

$router->group(['prefix' => 'product'], function (Router $router) {
    $router->get('', 'ProductController@getIndex')
        ->name('admin::product.posts.index.get');


    $router->post('/', 'ProductController@postListing')
        ->name('admin::product.posts.index.post')
       ;

    $router->get('create', 'ProductController@getCreate')
        ->name('admin::product.posts.create.get')
       ;

    $router->post('create', 'ProductController@postCreate')
        ->name('admin::product.posts.create.post')
       ;

    $router->get('edit/{id}', 'ProductController@getEdit')
        ->name('admin::product.posts.edit.get')
       ;

    $router->post('edit/{id}', 'ProductController@postEdit')
        ->name('admin::product.posts.edit.post')
       ;

    $router->post('update-status/{id}/{status}', 'ProductController@postUpdateStatus')
        ->name('admin::product.posts.update-status.post')
       ;

    $router->post('delete/{id}', 'ProductController@postDelete')
        ->name('admin::product.posts.delete.post')
        ;

    $router->post('force-delete/{id}', 'ProductController@postForceDelete')
        ->name('admin::product.posts.force-delete.post')
       ;

    $router->post('restore/{id}', 'ProductController@postRestore')
        ->name('admin::product.posts.restore.post')
        ;
});
