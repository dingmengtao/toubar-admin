<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('webed.admin_route');

$moduleRoute = 'users';

/*
 * Admin route
 * */
Route::group(['prefix' => $adminRoute, 'namespace' => 'WebEd\Base\Users\Http\Controllers'], function (Router $router) use ($adminRoute, $moduleRoute) {
    $router->group(['prefix' => 'auth'], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get($moduleRoute, function () use ($adminRoute, $moduleRoute) {
            return redirect()->to($adminRoute . '/' . $moduleRoute . '/login');
        });

        $router->get('login', 'AuthController@getLogin')->name('admin::auth.login.get');
        $router->post('login', 'AuthController@postLogin')->name('admin::auth.login.post');
        $router->get('logout', 'AuthController@getLogout')->name('admin::auth.logout.get');
    });

    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('/', 'UserController@getIndex')
            ->name('admin::users.index.get')
            ->middleware('has-permission:view-users');

        $router->post('/', 'UserController@postListing')
            ->name('admin::users.index.post')
            ->middleware('has-permission:view-users');

        $router->post('update-status/{id}/{status}', 'UserController@postUpdateStatus')
            ->name('admin::users.update-status.post')
            ->middleware('has-permission:edit-other-users');

        $router->post('restore/{id}', 'UserController@postRestore')
            ->name('admin::users.restore.post')
            ->middleware('has-permission:edit-other-users');

        $router->get('create', 'UserController@getCreate')
            ->name('admin::users.create.get')
            ->middleware('has-permission:create-users');

        $router->post('create', 'UserController@postCreate')
            ->name('admin::users.create.post')
            ->middleware('has-permission:create-users');

        $router->get('edit/{id}', 'UserController@getEdit')
            ->name('admin::users.edit.get');
        $router->post('edit/{id}', 'UserController@postEdit')
            ->name('admin::users.edit.post');

        $router->post('update-password/{id}', 'UserController@postUpdatePassword')
            ->name('admin::users.update-password.post');

        $router->post('delete/{id}', 'UserController@postDelete')
            ->name('admin::users.delete.post')
            ->middleware('has-permission:delete-users');

        $router->post('force-delete/{id}', 'UserController@postForceDelete')
            ->name('admin::users.force-delete.post')
            ->middleware('has-permission:force-delete-users');
    });
});

/**
 * Front site
 */
Route::group(do_filter(BASE_FILTER_PUBLIC_ROUTE, [], WEBED_USERS), function () {
    Route::group(['prefix' => 'auth'], function (Router $router) {
        $router->get('/', function () {
            return redirect()->to('auth/login');
        });

        $router->get('logout', config('webed-auth.front_actions.login.controller') . '@getLogout')
            ->middleware('webed.auth-front')
            ->name('front::auth.logout.get');

        $router->group(['middleware' => ['webed.guest-front']], function(Router $router) {
            /**
             * Login
             */
            $router->get('login', config('webed-auth.front_actions.login.controller') . '@getLogin')
                ->name('front::auth.login.get');
            $router->post('login', config('webed-auth.front_actions.login.controller') . '@postLogin')
                ->name('front::auth.login.post');

            /**
             * Register
             */
            $router->get('register', config('webed-auth.front_actions.register.controller') . '@getIndex')
                ->name('front::auth.register.get');
            $router->post('register', config('webed-auth.front_actions.register.controller') . '@postIndex')
                ->name('front::auth.register.post');

            /**
             * Forgot password
             */
            $router->get('forgot-password', config('webed-auth.front_actions.forgot_password.controller') . '@getIndex')
                ->name('front::auth.forgot_password.get');
            $router->post('forgot-password', config('webed-auth.front_actions.forgot_password.controller') . '@postIndex')
                ->name('front::auth.forgot_password.post');

            /**
             * Reset password
             */
            $router->get('reset-password', config('webed-auth.front_actions.reset_password.controller') . '@getIndex')
                ->name('front::auth.reset_password.get');
            $router->post('reset-password', config('webed-auth.front_actions.reset_password.controller') . '@postIndex')
                ->name('front::auth.reset_password.post');

            /**
             * Social login
             */
            $router->get('social-login/{provider}', config('webed-auth.front_actions.social_login.controller').'@redirectToProvider')
                ->name('front::auth.social.login');
            $router->get('social-login/{provider}/callback', config('webed-auth.front_actions.social_login.controller').'@handleProviderCallback')
                ->name('front::auth.social.login.callback');
        });
    });
});
