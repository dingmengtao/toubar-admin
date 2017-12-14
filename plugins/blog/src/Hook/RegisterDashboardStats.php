<?php namespace WebEd\Plugins\Blog\Hook;

use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class RegisterDashboardStats
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(PostRepositoryContract $postRepository, CategoryRepositoryContract $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function handle()
    {
        echo view('webed-blog::admin.dashboard-stats.stat-box', [
            'postsCount' => $this->postRepository->count(),
            'categoriesCount' => $this->categoryRepository->count(),
        ]);
    }
}
