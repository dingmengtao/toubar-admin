<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'modules-management';

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('', function () {
        return redirect(route('admin::core-modules.index.get'));
    });

    $router->group(['prefix' => 'plugins'], function() use ($router) {
        $router->get('', 'PluginsController@getIndex')
            ->name('admin::plugins.index.get')
            ->middleware('has-permission:view-plugins');

        $router->post('', 'PluginsController@postListing')
            ->name('admin::plugins.index.post')
            ->middleware('has-permission:view-plugins');

        $router->post('change-status/{module}/{status}', 'PluginsController@postChangeStatus')
            ->name('admin::plugins.change-status.post')
            ->middleware('has-role:super-admin');

        $router->post('install/{module}', 'PluginsController@postInstall')
            ->name('admin::plugins.install.post')
            ->middleware('has-role:super-admin');

        $router->post('update/{module}', 'PluginsController@postUpdate')
            ->name('admin::plugins.update.post')
            ->middleware('has-role:super-admin');

        $router->post('uninstall/{module}', 'PluginsController@postUninstall')
            ->name('admin::plugins.uninstall.post')
            ->middleware('has-role:super-admin');
    });

    $router->group(['prefix' => 'core-modules'], function() use ($router) {
        $router->get('', 'CoreModulesController@getIndex')
            ->name('admin::core-modules.index.get')
            ->middleware('has-permission:view-plugins');

        $router->post('', 'CoreModulesController@postListing')
            ->name('admin::core-modules.index.post')
            ->middleware('has-permission:view-plugins');

        $router->post('update/{module}', 'CoreModulesController@postUpdate')
            ->name('admin::core-modules.update.post')
            ->middleware('has-role:super-admin');
    });
});
