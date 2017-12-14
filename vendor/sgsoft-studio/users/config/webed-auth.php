<?php

return [
    'login_using' => 'email',
    'guard' => 'web',
    'front_actions' => [
        'guard' => 'web',
        'login' => [
            'view' => 'webed-theme::front.auth.login',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\AuthFrontController::class,
        ],
        'register' => [
            'view' => 'webed-theme::front.auth.register',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\RegisterController::class,
        ],
        'forgot_password' => [
            'view' => 'webed-theme::front.auth.forgot-password',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\ForgotPasswordController::class,
            'email_template' => WEBED_USERS . '::front.emails.forgot-password',
            /**
             * The unit is in minute. Only accept integer.
             */
            'link_expired_after' => 60,
        ],
        'reset_password' => [
            'view' => 'webed-theme::front.auth.reset-password',
            'controller' => WebEd\Base\Users\Http\Controllers\Front\ResetPasswordController::class,
            'auto_sign_in_after_reset' => true,
            'remember_login' => true,
        ],
        'social_login' => [
            'controller' => WebEd\Base\Users\Http\Controllers\Front\SocialAuthController::class,
        ],
    ],
];
