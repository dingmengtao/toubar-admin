<?php namespace WebEd\Base\Hook\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Hook\Support\Actions;

class ActionsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Actions::class;
    }
}
