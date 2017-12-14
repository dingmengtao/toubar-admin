<?php namespace WebEd\Base\Shortcode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author Webwizo - <https://github.com/webwizo/laravel-shortcodes>
 */
class ShortcodeFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shortcode';
    }
}
