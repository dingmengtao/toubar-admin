<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'blog';

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) {
    require 'web/posts.php';
    require 'web/categories.php';
    require 'web/tags.php';
    require  'web/news.php';
    require  'web/navigation.php';

});

/**
 * Front site routes
 */
//Route::get(config('webed-blog.front_url_prefix') . '/{slug}', 'Front\ResolveBlogController@handle')
//    ->name('front.web.resolve-blog.get');

Route::get(config('webed-blog.front_url_prefix') . '/tag/{slug}.html', 'Front\TagController@handle')
    ->name('front.web.blog.tags.get');
Route::get(config('webed-blog.front_url_prefix') . '/{slug}/{id?}', 'Front\PostController@read')
    ->name('front.web.resolve-blog.get');
