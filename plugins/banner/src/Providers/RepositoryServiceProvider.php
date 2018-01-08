<?php namespace WebEd\Plugins\Banner\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Banner\Repositories\BannerRepository;
use  WebEd\Plugins\Banner\Repositories\Contracts\BannerRepositoryContract;
use WebEd\Plugins\Banner\Models\Banner;
use WebEd\Plugins\Banner\Repositories\BannerRepositoryCacheDecorator;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BannerRepository::class, function () {
            $repository = new BannerRepository(new Banner());

            if (config('webed-caching.repository.enabled')) {
                return new BannerRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }

            return $repository;
        });
    }
}
