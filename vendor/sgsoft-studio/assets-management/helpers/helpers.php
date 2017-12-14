<?php

if (!function_exists('assets_management')) {
    /**
     * @return \WebEd\Base\AssetsManagement\Assets
     */
    function assets_management()
    {
        return \WebEd\Base\AssetsManagement\Facades\AssetsFacade::getFacadeRoot();
    }
}

if (!function_exists('assets_list')) {
    /**
     * @return array
     */
    function assets_list()
    {
        return assets_management()->getAssetsList();
    }
}