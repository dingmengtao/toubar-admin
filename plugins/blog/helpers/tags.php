<?php

use WebEd\Plugins\Blog\Models\BlogTag;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

if (!function_exists('get_tag_link')) {
    /**
     * @param BlogTag $tag
     * @return string
     */
    function get_tag_link($tag)
    {
        $slug = is_string($tag) ? $tag : $tag->slug;
        return route('front.web.blog.tags.get', ['slug' => $slug]);
    }
}

if (!function_exists('get_tags')) {
    /**
     * @param mixed
     */
    function get_tags(array $params = [])
    {
        return app(BlogTagRepositoryContract::class)->getTags($params);
    }
}
