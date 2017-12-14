<?php

use WebEd\Base\Pages\Models\Page;

if (!function_exists('get_page_link')) {
    /**
     * @param string|Page $page
     * @param array $queryString
     * @return string
     */
    function get_page_link($page, array $queryString = [])
    {
        if (is_string($page)) {
            $slug = $page;
        } elseif (is_object($page)) {
            $slug = $page->slug;
        } else {
            $slug = null;
        }
        return route('front.web.resolve-pages.get', array_merge($queryString, ['slug' => $slug]));
    }
}
