<?php namespace WebEd\Base\Pages\Facades;

use Illuminate\Support\Facades\Facade;
use WebEd\Base\Pages\Support\HomepageSupport;

class HomepageFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HomepageSupport::class;
    }
}
