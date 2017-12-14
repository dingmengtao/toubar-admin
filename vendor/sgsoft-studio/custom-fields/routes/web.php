<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

/**
 * Admin routes
 */
Route::group(['prefix' => $adminRoute . '/custom-fields'], function (Router $router) use ($adminRoute) {
    $router->get('/', 'CustomFieldController@getIndex')
        ->name('admin::custom-fields.index.get')
        ->middleware('has-permission:view-custom-fields');

    $router->post('/', 'CustomFieldController@postListing')
        ->name('admin::custom-fields.index.post')
        ->middleware('has-permission:view-custom-fields');

    $router->post('/update-status/{id}/{status}', 'CustomFieldController@postUpdateStatus')
        ->name('admin::custom-fields.field-group.update-status.post')
        ->middleware('has-permission:edit-field-groups');

    $router->get('/create', 'CustomFieldController@getCreate')
        ->name('admin::custom-fields.field-group.create.get')
        ->middleware('has-permission:create-field-groups');

    $router->post('/create', 'CustomFieldController@postCreate')
        ->name('admin::custom-fields.field-group.create.post')
        ->middleware('has-permission:create-field-groups');

    $router->get('/edit/{id}', 'CustomFieldController@getEdit')
        ->name('admin::custom-fields.field-group.edit.get')
        ->middleware('has-permission:view-custom-fields');

    $router->post('/edit/{id}', 'CustomFieldController@postEdit')
        ->name('admin::custom-fields.field-group.edit.post')
        ->middleware('has-permission:edit-field-groups');

    $router->post('/delete/{id}', 'CustomFieldController@postDelete')
        ->name('admin::custom-fields.field-group.delete.post')
        ->middleware('has-permission:delete-field-groups');

    $router->get('/export/{id?}', 'CustomFieldController@getExport')
        ->name('admin::custom-fields.field-group.export.get')
        ->middleware('has-permission:edit-field-groups');

    $router->post('/import', 'CustomFieldController@postImport')
        ->name('admin::custom-fields.field-group.import.post')
        ->middleware('has-permission:edit-field-groups');

});
