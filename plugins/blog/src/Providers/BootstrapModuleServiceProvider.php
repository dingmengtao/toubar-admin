<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Base\Events\SessionStarted;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen(SessionStarted::class, function () {
            $this->onSessionStarted();
        });
    }

    /**
     * Register dashboard menus, translations, cms settings
     */
    protected function onSessionStarted()
    {
        admin_bar()
            ->registerLink(trans('webed-blog::base.admin_bar.post'), route('admin::blog.posts.create.get'), 'add-new')
            ->registerLink(trans('webed-blog::base.admin_bar.category'), route('admin::blog.categories.create.get'), 'add-new');

        admin_quick_link()
            ->register('post', [
                'title' => trans('webed-blog::base.admin_bar.post'),
                'url' => route('admin::blog.posts.create.get'),
                'icon' => 'icon-book-open',
            ])
            ->register('category', [
                'title' => trans('webed-blog::base.admin_bar.category'),
                'url' => route('admin::blog.categories.create.get'),
                'icon' => 'fa fa-sitemap',
            ])
            ->register('tag', [
                'title' => trans('webed-blog::base.admin_bar.tag'),
                'url' => route('admin::blog.tags.create.get'),
                'icon' => 'icon-tag',
            ]);

        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => WEBED_BLOG_POSTS,
            'priority' => 2,
            'parent_id' => null,
            'heading' => 'Blog',
            'title' => trans('webed-blog::base.admin_menu.posts'),
            'font_icon' => 'icon-book-open',
            'link' => route('admin::blog.posts.index.get'),
            'css_class' => null,
            'permissions' => ['view-posts'],
        ])->registerItem([
            'id' => WEBED_BLOG_CATEGORIES,
            'priority' => 2.1,
            'parent_id' => null,
            'title' => trans('webed-blog::base.admin_menu.categories'),
            'font_icon' => 'fa fa-sitemap',
            'link' => route('admin::blog.categories.index.get'),
            'css_class' => null,
            'permissions' => ['view-categories'],
        ])->registerItem([
            'id' => WEBED_BLOG_TAGS,
            'priority' => 2.2,
            'parent_id' => null,
            'title' => trans('webed-blog::base.admin_menu.tags'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::blog.tags.index.get'),
            'css_class' => null,
            'permissions' => ['view-tags'],
        ])->registerItem([
            'id' => WEBED_BLOG_NEWS,
            'priority' => 2.3,
            'parent_id' => WEBED_BLOG_POSTS,
            'title' => trans('webed-blog::base.admin_menu.news'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::blog.news.index.get'),
            'css_class' => null,
            'permissions' => ['view-news'],
        ])
//            ->registerItem([
//            'id' => 'webed-navgition',
//            'priority' => 1.1,
//            'parent_id' => null,
//            'title' => '导航',
//            'font_icon' => 'icon-notebook',
//            'link' => route('admin::navigation.index.get'),
//            'css_class' => null,
//            'permissions' => ['view-pages'],
//        ])
            ->registerItem([
            'id' => WEBED_BLOG_PRODUCTS,
            'priority' => 2.4,
            'parent_id' => WEBED_BLOG_POSTS,
            'title' => trans('webed-blog::base.admin_menu.products'),
            'font_icon' => 'icon-tag',
            'link' => route('admin::product.posts.index.get'),
            'css_class' => null,
            'permissions' => ['view-products'],
        ]);
        /**
         * 添加模板
         */

        add_new_template([
            'Product' => 'Product',
        ], WEBED_BLOG_PRODUCTS);
        add_new_template([
            'News' => 'News',
        ], WEBED_BLOG_NEWS);

        /**
         * Register menu widget
         */
        menus_management()->registerWidget(trans('webed-blog::base.categories.page_title'), 'category', function () {
            $categories = get_categories_with_children([
                'select' => [
                    'title', 'slug', 'id', 'parent_id',
                ],
            ]);
            return $this->parseMenuWidgetData($categories);
        });

        /**
         * Register menu link type
         */
        menus_management()->registerLinkType('category', function ($id) {
            $category = app(CategoryRepositoryContract::class)
                ->find($id, [
                    'slug', 'title',
                ]);
            if (!$category) {
                return null;
            }
            return [
                'model_title' => $category->title,
                'url' => get_category_link($category->slug),
            ];
        });

        $this->registerBlogFields();
    }

    protected function parseMenuWidgetData($categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'title' => $category->title,
                'children' => $this->parseMenuWidgetData($category->child_cats)
            ];
        }
        return $result;
    }

    protected function registerBlogFields()
    {
        /**
         * Map the translations
         */
        lang()->addLines([
            'rules.groups.blog' => trans('webed-blog::custom-fields.groups.blog'),
        ], app()->getLocale(), 'webed-custom-fields');

        if (webed_plugins()->isActivated('webed-blog') && webed_plugins()->isInstalled('webed-blog')) {
            CustomFieldSupportFacade::registerRuleGroup('blog')
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_template'), WEBED_BLOG_POSTS . '.post_template', function () {
                    return get_templates(WEBED_BLOG_POSTS);
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.category_template'), WEBED_BLOG_CATEGORIES . '.category_template', function () {
                    return get_templates(WEBED_BLOG_CATEGORIES);
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.category'), WEBED_BLOG_CATEGORIES, function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_with_related_category'), WEBED_BLOG_POSTS . '.post_with_related_category', function () {
                    $categories = get_categories();

                    $categoriesArr = [];
                    foreach ($categories as $row) {
                        $categoriesArr[$row->id] = $row->indent_text . $row->title;
                    }
                    return $categoriesArr;
                })
                ->registerRule('blog', trans('webed-blog::custom-fields.rules.post_with_related_category_template'), WEBED_BLOG_POSTS . '.post_with_related_category_template', get_templates('blog_category'))
                ->registerRule('other', trans('webed-custom-fields::rules.model_name'), 'model_name', function () {
                    return [
                        WEBED_BLOG_POSTS => trans('webed-blog::custom-fields.rules.model_name_post'),
                        WEBED_BLOG_CATEGORIES => trans('webed-blog::custom-fields.rules.model_name_category'),
                    ];
                });
        }
    }
}
