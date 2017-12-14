<?php namespace WebEd\Base\ModulesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ModulesManagement\Support\CoreModulesSupport;

class CoreModulesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CoreModulesSupport::class;
    }
}
