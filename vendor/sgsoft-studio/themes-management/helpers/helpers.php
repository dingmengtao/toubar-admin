<?php

use WebEd\Base\ThemesManagement\Facades\ThemesFacade;

if (!function_exists('webed_themes_path')) {
    /**
     * @param string $path
     * @return string
     */
    function webed_themes_path($path = '')
    {
        return base_path('themes') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('themes_management')) {
    /**
     * @return \WebEd\Base\ThemesManagement\Support\ThemesManagement
     */
    function themes_management()
    {
        return \WebEd\Base\ThemesManagement\Facades\ThemesManagementFacade::getFacadeRoot();
    }
}

if (!function_exists('get_all_theme_information')) {
    /**
     * @return array|\Illuminate\Support\Collection
     */
    function get_all_theme_information($toArray = true)
    {
        return ThemesFacade::getAllThemes($toArray);
    }
}

if (!function_exists('get_theme_information')) {
    /**
     * @param $alias
     * @return mixed
     */
    function get_theme_information($alias)
    {
        return ThemesFacade::findByAlias($alias);
    }
}

if (!function_exists('theme_exists')) {
    /**
     * @param $alias
     * @return mixed
     */
    function theme_exists($alias)
    {
        return !!ThemesFacade::findByAlias($alias);;
    }
}

if (!function_exists('save_theme_information')) {
    /**
     * @param $alias
     * @param array $data
     * @return bool
     */
    function save_theme_information($alias, array $data)
    {
        return ThemesFacade::saveTheme($alias, $data);
    }
}

if (!function_exists('is_theme_enabled')) {
    /**
     * @param $alias
     * @return bool
     */
    function is_theme_enabled($alias)
    {
        $theme = ThemesFacade::findByAlias($alias);
        if (!$theme || !array_get($theme, 'enabled')) {
            return false;
        }
        return true;
    }
}

if (!function_exists('is_theme_installed')) {
    /**
     * @param $alias
     * @return bool
     */
    function is_theme_installed($alias)
    {
        $theme = ThemesFacade::findByAlias($alias);
        if (!$theme || !array_get($theme, 'installed')) {
            return false;
        }
        return true;
    }
}

if (!function_exists('get_current_theme')) {
    /**
     * Get current activated theme
     * @return mixed
     */
    function get_current_theme()
    {
        return ThemesFacade::getCurrentTheme();
    }
}
