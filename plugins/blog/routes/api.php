<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('webed.api_route'), 'namespace' => 'Front\Api'], function (Router $router) {
    $router->resource('posts', 'PostController');
});
