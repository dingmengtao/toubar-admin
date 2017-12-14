<?php namespace DummyNamespace\Http\Controllers\Blog;

use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Contracts\CategoryModelContract;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use DummyNamespace\Http\Controllers\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @var Category
     */
    protected $category;

    public function __construct(CategoryRepositoryContract $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * @param Category $item
     * @param array $data
     * @return mixed
     */
    public function handle(CategoryModelContract $item, array $data)
    {
        $this->dis = $data;

        $this->category = $item;

        $this->getMenu('category', $item->id);

        $happyMethod = '_template_' . studly_case($item->page_template);

        if(method_exists($this, $happyMethod)) {
            return $this->$happyMethod();
        }
        return $this->defaultTemplate();
    }

    /**
     * @return mixed
     */
    protected function defaultTemplate()
    {
        $this->dis['relatedPosts'] = get_posts_by_category($this->category->id);

        if(view()->exists($this->currentThemeName . '::front.blog.category-templates.' . str_slug($this->category->page_template))) {
            return $this->view('front.blog.category-templates.' . str_slug($this->category->page_template));
        }

        return $this->view('front.blog.category-templates.default');
    }
}
