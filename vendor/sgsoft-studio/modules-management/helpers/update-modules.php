<?php

use \WebEd\Base\ModulesManagement\Support\UpdateModulesSupport;
use \WebEd\Base\ModulesManagement\Facades\UpdateModulesFacade;

if (!function_exists('register_module_update_batches')) {
    /**
     * @param $moduleAlias
     * @param array $batches
     * @param string $type
     * @return UpdateModulesSupport
     */
    function register_module_update_batches($moduleAlias, array $batches, $type = 'plugins')
    {
        return UpdateModulesFacade::registerUpdateBatches($moduleAlias, $batches, $type);
    }
}

if (!function_exists('load_module_update_batches')) {
    /**
     * @param $moduleAlias
     * @param string $type
     * @return UpdateModulesSupport
     */
    function load_module_update_batches($moduleAlias, $type = 'plugins')
    {
        return UpdateModulesFacade::loadBatches($moduleAlias, $type);
    }
}
