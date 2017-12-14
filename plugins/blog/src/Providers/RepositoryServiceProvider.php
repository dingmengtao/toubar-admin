<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blog\Models\BlogTag;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Models\Post;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\BlogTagRepositoryCacheDecorator;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\CategoryRepositoryCacheDecorator;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;
use WebEd\Plugins\Blog\Repositories\PostRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryContract::class, function () {
            $repository = new PostRepository(new Post());

            if (config('webed-caching.repository.enabled')) {
                return new PostRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }

            return $repository;
        });

        $this->app->bind(CategoryRepositoryContract::class, function () {
            $repository = new CategoryRepository(new Category());

            if (config('webed-caching.repository.enabled')) {
                return new CategoryRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }

            return $repository;
        });

        $this->app->bind(BlogTagRepositoryContract::class, function () {
            $repository = new BlogTagRepository(new BlogTag());

            if (config('webed-caching.repository.enabled')) {
                return new BlogTagRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }

            return $repository;
        });
    }
}
