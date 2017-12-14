<?php

use WebEd\Base\ThemesManagement\Facades\ThemeOptionsSupportFacade;

if (!function_exists('cms_theme_options')) {
    /**
     * @return \WebEd\Base\ThemesManagement\Support\ThemeOptionsSupport
     */
    function cms_theme_options()
    {
        return ThemeOptionsSupportFacade::getFacadeRoot();
    }
}

if (!function_exists('get_theme_option')) {
    /**
     * @param null $key
     * @param null $default
     * @return array|string
     */
    function get_theme_option($key = null, $default = null)
    {
        return ThemeOptionsSupportFacade::getOption($key, $default);
    }
}
