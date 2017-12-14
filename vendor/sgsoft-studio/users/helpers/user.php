<?php

use WebEd\Base\Users\Facades\CurrentUserFacade;

if (!function_exists('get_current_logged_user')) {
    /**
     * @return \WebEd\Base\Users\Models\User|null
     */
    function get_current_logged_user($guard = null)
    {
        $guard = $guard ?: config('webed-auth.guard');

        return CurrentUserFacade::getUser($guard);
    }
}

if (!function_exists('get_current_logged_user_id')) {
    /**
     * @return int|null
     */
    function get_current_logged_user_id($guard = null)
    {
        $guard = $guard ?: config('webed-auth.guard');

        $user = get_current_logged_user($guard);

        return $user ? $user->id : null;
    }
}
