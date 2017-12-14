<?php namespace WebEd\Base\ModulesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ModulesManagement\Support\PluginsSupport;

class PluginsFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PluginsSupport::class;
    }
}
