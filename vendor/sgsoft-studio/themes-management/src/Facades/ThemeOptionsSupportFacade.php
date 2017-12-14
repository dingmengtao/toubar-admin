<?php namespace WebEd\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ThemesManagement\Support\ThemeOptionsSupport;

class ThemeOptionsSupportFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOptionsSupport::class;
    }
}
