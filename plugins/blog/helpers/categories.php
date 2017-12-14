<?php

use WebEd\Plugins\Blog\Models\Category;

if (!function_exists('get_category_link')) {
    /**
     * @param Category $category
     * @return string
     */
    function get_category_link($category)
    {
        $slug = is_string($category) ? $category : $category->slug;
        return route('front.web.resolve-blog.get', ['slug' => $slug]);
    }
}

if (!function_exists('get_categories')) {
    /**
     * @param array $args
     * @param bool $withTrash
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|mixed
     */
    function get_categories(array $args = [], $withTrash = false)
    {
        $indent = array_get($args, 'indent', '——');

        /**
         * @var \WebEd\Plugins\Blog\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo->getCategories(array_merge($args, [
            'order_by' => [
                'order' => 'ASC',
                'created_at' => 'DESC'
            ],
        ]), $withTrash);
        $categories = sort_item_with_children($categories);

        foreach ($categories as $category) {
            $indentText = '';
            $depth = (int)$category->depth;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $category->indent_text = $indentText;
        }

        return $categories;
    }
}

if (!function_exists('get_categories_with_children')) {
    /**
     * @param array $args
     * @param bool $withTrash
     * @return array
     */
    function get_categories_with_children(array $args = [], $withTrash = false)
    {
        /**
         * @var \WebEd\Plugins\Blog\Repositories\CategoryRepository $repo
         */
        $repo = app(\WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract::class);
        $categories = $repo->getCategories($args, $withTrash);

        /**
         * @var \WebEd\Base\Support\SortItemsWithChildrenHelper $sortHelper
         */
        $sortHelper = app(\WebEd\Base\Support\SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($categories);

        return $sortHelper->sort();
    }
}
