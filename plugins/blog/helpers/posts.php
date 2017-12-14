<?php

use WebEd\Plugins\Blog\Models\Post;
use \WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;

if (!function_exists('get_post_link')) {
    /**
     * @param Post $post
     * @return string
     */
    function get_post_link($post)
    {
        $slug = is_string($post) ? $post : $post->slug;
        $id=(!empty($post->id))?$post->id:'0';
        return route('front.web.resolve-blog.get', ['slug' => $slug,'id'=> $id]);
    }
}

if (!function_exists('get_posts_by_category')) {
    /**
     * @param array|int $categoryIds
     * @param array $params
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    function get_posts_by_category($categoryIds, array $params = [])
    {
        /**
         * @var \WebEd\Plugins\Blog\Repositories\PostRepository $postRepo
         */
        $postRepo = app(PostRepositoryContract::class);

        return $postRepo->getPostsByCategory($categoryIds, $params);
    }
}

if (!function_exists('get_posts_by_tag')) {
    /**
     * @param array|int $categoryIds
     * @param array $params
     * @return \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator
     */
    function get_posts_by_tag($tagIds, array $params = [])
    {
        /**
         * @var \WebEd\Plugins\Blog\Repositories\PostRepository $postRepo
         */
        $postRepo = app(PostRepositoryContract::class);

        return $postRepo->getPostsByTag($tagIds, $params);
    }
}

if (!function_exists('get_posts')) {
    /**
     * @param mixed
     */
    function get_posts(array $params = [])
    {
        return app(PostRepositoryContract::class)->getPosts($params);
    }
}
