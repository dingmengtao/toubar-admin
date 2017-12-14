<?php namespace WebEd\Plugins\Blog\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class TagController extends BaseFrontController
{
    /**
     * @var BlogTagRepository
     */
    protected $repository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(
        BlogTagRepositoryContract $repository,
        PostRepositoryContract $postRepository
    )
    {
        parent::__construct();

        $this->themeController = themes_management()->getThemeController('Blog\Tag');

        if (!$this->themeController) {
            echo 'You need to active a theme';
            die();
        }

        if (is_string($this->themeController)) {
            echo 'Class ' . $this->themeController . ' not exists';
            die();
        }

        $this->repository = $repository;

        $this->postRepository = $postRepository;
    }

    /**
     * @param Category $item
     * @return mixed
     */
    public function handle($slug)
    {
        $item = $this->repository
            ->findWhere([
                'slug' => $slug,
                'status' => 1
            ]);

        if (!$item) {
            abort(\Constants::NOT_FOUND_CODE);
        }

        $this->setPageTitle($item->title);

        $this->dis['object'] = $item;

        increase_view_count(WEBED_BLOG_TAGS, $item->id);

        return $this->themeController->handle($item, $this->dis);
    }
}
