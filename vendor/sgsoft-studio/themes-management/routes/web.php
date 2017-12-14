<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute) {
    $router->group(['prefix' => 'themes-management'], function (Router $router) use ($adminRoute) {
        $router->get('', 'ThemeController@getIndex')
            ->name('admin::themes.index.get')
            ->middleware('has-permission:view-themes');
        $router->post('', 'ThemeController@postListing')
            ->name('admin::themes.index.post')
            ->middleware('has-permission:view-themes');

        $router->post('change-status/{module}/{status}', 'ThemeController@postChangeStatus')
            ->name('admin::themes.change-status.post')
            ->middleware('has-role:super-admin');

        $router->post('install/{module}', 'ThemeController@postInstall')
            ->name('admin::themes.install.post')
            ->middleware('has-role:super-admin');

        $router->post('update/{module}', 'ThemeController@postUpdate')
            ->name('admin::themes.update.post')
            ->middleware('has-role:super-admin');

        $router->post('uninstall/{module}', 'ThemeController@postUninstall')
            ->name('admin::themes.uninstall.post')
            ->middleware('has-role:super-admin');
    });
    $router->group(['prefix' => 'theme-options'], function (Router $router) use ($adminRoute) {
        $router->get('', 'ThemeOptionController@getIndex')
            ->name('admin::theme-options.index.get')
            ->middleware('has-permission:view-theme-options');
        $router->post('', 'ThemeOptionController@postIndex')
            ->name('admin::theme-options.index.post')
            ->middleware('has-role:update-theme-options');
    });
});
