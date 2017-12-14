<?php

use \WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;

if (!function_exists('get_pages')) {
    /**
     * @param mixed
     */
    function get_pages(array $params = [])
    {
        return app(PageRepositoryContract::class)->getPages($params);
    }
}

if (!function_exists('get_homepage')) {
    /**
     * @return \WebEd\Base\Pages\Models\Page|null
     */
    function get_homepage()
    {
        return \WebEd\Base\Pages\Facades\HomepageFacade::getHomepage();
    }
}

if (!function_exists('get_homepage_link')) {
    /**
     * @param string $defaultUrl
     * @return string|null
     */
    function get_homepage_link($defaultUrl = null)
    {
        return \WebEd\Base\Pages\Facades\HomepageFacade::getHomepageLink($defaultUrl);
    }
}
