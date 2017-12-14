<?php namespace WebEd\Base\Users\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Users\Support\CurrentUserSupport;

class CurrentUserFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CurrentUserSupport::class;
    }
}
