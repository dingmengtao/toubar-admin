<?php namespace WebEd\Base\Users\Support;

use Illuminate\Support\Facades\Auth;
use WebEd\Base\Users\Models\User;

class CurrentUserSupport
{
    /**
     * @return User|null
     */
    public function getUser($guard)
    {
        return Auth::guard($guard)->getUser();
    }
}
