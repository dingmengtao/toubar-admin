<?php namespace WebEd\Base\ThemesManagement\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\ThemesManagement\Support\Themes;
use Illuminate\Support\Collection;

/**
 * @method static array|Collection getAllThemes(bool $toArray = true)
 * @method static findByAlias(string $alias)
 * @method static getCurrentTheme()
 * @method static saveTheme($alias, array $data)
 */
class ThemesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Themes::class;
    }
}
