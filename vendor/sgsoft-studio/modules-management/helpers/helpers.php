<?php

if (!function_exists('webed_plugins_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_plugins_path($path = '')
    {
        return base_path('plugins') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('webed_core_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_core_path($path = '')
    {
        return base_path('core') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('modules_management')) {
    /**
     * @return \WebEd\Base\ModulesManagement\Support\ModulesManagement
     */
    function modules_management()
    {
        return \WebEd\Base\ModulesManagement\Facades\ModulesManagementFacade::getFacadeRoot();
    }
}
