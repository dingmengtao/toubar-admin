<?php namespace WebEd\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ThemesManagement\Support\UpdateThemesSupport;

class UpdateThemesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return UpdateThemesSupport::class;
    }
}
