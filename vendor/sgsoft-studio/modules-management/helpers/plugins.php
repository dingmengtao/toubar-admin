<?php

use Illuminate\Support\Collection;
use WebEd\Base\ModulesManagement\Facades\PluginsFacade;

if (!function_exists('webed_plugins')) {
    /**
     * @return \WebEd\Base\ModulesManagement\Support\PluginsSupport
     */
    function webed_plugins()
    {
        return PluginsFacade::getFacadeRoot();
    }
}

if (!function_exists('get_plugin')) {
    /**
     * @param string
     * @return Collection|array
     */
    function get_plugin($alias = null)
    {
        if ($alias) {
            return webed_plugins()->findByAlias($alias);
        }
        return webed_plugins()->getAllPlugins();
    }
}

if (!function_exists('save_plugin_information')) {
    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    function save_plugin_information($alias, array $data)
    {
        return webed_plugins()->savePlugin($alias, $data);
    }
}
