<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'acl';

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/' . $moduleRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->get('', function () {
        return redirect()->to(route('admin::acl-roles.index.get'));
    });
    /**
     * Roles
     */
    $router->group(['prefix' => 'roles'], function (Router $router) {
        $router->get('', 'RoleController@getIndex')
            ->name('admin::acl-roles.index.get')
            ->middleware('has-permission:view-roles');

        $router->post('', 'RoleController@postListing')
            ->name('admin::acl-roles.index.post')
            ->middleware('has-permission:view-roles');

        $router->get('create', 'RoleController@getCreate')
            ->name('admin::acl-roles.create.get')
            ->middleware('has-permission:create-roles');

        $router->post('create', 'RoleController@postCreate')
            ->name('admin::acl-roles.create.post')
            ->middleware('has-permission:create-roles');

        $router->get('edit/{id}', 'RoleController@getEdit')
            ->name('admin::acl-roles.edit.get')
            ->middleware('has-permission:view-roles');

        $router->post('edit/{id}', 'RoleController@postEdit')
            ->name('admin::acl-roles.edit.post')
            ->middleware('has-permission:edit-roles');

        $router->post('{id}', 'RoleController@postDelete')
            ->name('admin::acl-roles.delete.post')
            ->middleware('has-permission:delete-roles');
    });


    /**
     * Permissions
     */
    $router->group(['prefix' => 'permissions'], function (Router $router) {
        $router->get('', 'PermissionController@getIndex')
            ->name('admin::acl-permissions.index.get')
            ->middleware('has-permission:view-permissions');

        $router->post('', 'PermissionController@postListing')
            ->name('admin::acl-permissions.index.post')
            ->middleware('has-permission:view-permissions');
    });
});
