<?php namespace WebEd\Plugins\Blog\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class ResolveBlogController extends BaseFrontController
{
    /**
     * @var PostRepositoryContract|PostRepository
     */
    protected $repository;

    /**
     * @var PostRepositoryContract|PostRepository
     */
    protected $categoryRepository;

    /**
     * @param PostRepositoryContract|PostRepository $repository
     * @param CategoryRepositoryContract|CategoryRepository $categoryRepositoryContract
     */
    public function __construct(
        PostRepositoryContract $repository,
        CategoryRepositoryContract $categoryRepositoryContract
    )
    {
        parent::__construct();

        $this->repository = $repository;

        $this->categoryRepository = $categoryRepositoryContract;
    }

    /**
     * First, we will find the post match this slug. If not exists, we will find the category match this slug.
     * @param $slug
     * @return mixed
     */
    public function handle($slug)
    {
        $item = $this->repository
            ->findWhere([
                'slug' => $slug,
                'status' => 1,
            ]);

        if ($item) {
            $item = do_filter(WEBED_BLOG_FRONT_POSTS, $item);

            increase_view_count(WEBED_BLOG_POSTS, $item->id);

            admin_bar()->registerLink('Edit this post', route('admin::blog.posts.edit.get', ['id' => $item->id]));

            $themeController = themes_management()->getThemeController('Blog\Post');

            if (is_string($themeController)) {
                abort(\Constants::ERROR_CODE, $themeController . ' not exists');
            }

            $this->dis['categoryIds'] = $this->repository->getRelatedCategoryIds($item);

            $this->dis['author'] = $item->author;

            seo()
                ->metaDescription($item->description)
                ->metaImage($item->thumbnail)
                ->metaKeywords($item->keywords)
                ->setModelObject($item);

            $this->themeController = $themeController;
        } else {
            $item = $this->categoryRepository
                ->findWhere([
                    'slug' => $slug,
                    'status' => 1,
                ]);

            if ($item) {
                $item = do_filter(WEBED_BLOG_FRONT_CATEGORIES, $item);

                increase_view_count(WEBED_BLOG_CATEGORIES, $item->id);

                admin_bar()->registerLink('Edit this category', route('admin::blog.categories.edit.get', ['id' => $item->id]));

                $themeController = themes_management()->getThemeController('Blog\Category');

                if (is_string($themeController)) {
                    abort(\Constants::ERROR_CODE, $themeController . ' not exists');
                }

                $this->dis['allRelatedCategoryIds'] = array_unique(array_merge($this->categoryRepository->getAllRelatedChildrenIds($item), [$item->id]));

                seo()
                    ->metaDescription($item->description)
                    ->metaImage($item->thumbnail)
                    ->metaKeywords($item->keywords)
                    ->setModelObject($item);

                $this->themeController = $themeController;
            }
        }
        if (!$item) {
            abort(\Constants::NOT_FOUND_CODE);
        }

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

        return $this->themeController->handle($item, $this->dis);
    }

}
