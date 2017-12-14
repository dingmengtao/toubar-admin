<?php namespace DummyNamespace\Http\Controllers\Blog;

use WebEd\Plugins\Blog\Models\Contracts\PostModelContract;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;
use DummyNamespace\Http\Controllers\AbstractController;

class PostController extends AbstractController
{
    /**
     * @var Post
     */
    protected $post;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(PostRepositoryContract $repository, CategoryRepositoryContract $categoryRepository)
    {
        parent::__construct();

        $this->repository = $repository;

        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Post $item
     * @return mixed
     */
    public function handle(PostModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->post = $item;

        $this->getMenu('category', $this->dis['categoryIds']);

        $happyMethod = '_template_' . studly_case($item->page_template);
        if (method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }
        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        if(view()->exists($this->currentThemeName . '::front.blog.post-templates.' . str_slug($this->post->page_template))) {
            return $this->view('front.blog.post-templates.' . str_slug($this->post->page_template));
        }
        return $this->view('front.blog.post-templates.default');
    }
}
