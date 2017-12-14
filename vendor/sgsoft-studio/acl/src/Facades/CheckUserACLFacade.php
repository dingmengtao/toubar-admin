<?php namespace WebEd\Base\ACL\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ACL\Support\CheckCurrentUserACL;
use WebEd\Base\ACL\Support\CheckUserACL;

class CheckUserACLFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CheckUserACL::class;
    }
}
