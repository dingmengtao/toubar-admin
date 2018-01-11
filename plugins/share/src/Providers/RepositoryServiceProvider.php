<?php namespace WebEd\Plugins\Share\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Share\Models\Share;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;
use WebEd\Plugins\Share\Repositories\ShareRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ShareRepositoryContract::class, function () {
            $repository = new ShareRepository(new Share());

            if (config('webed-caching.repository.enabled')) {
                return new ShareRepositoryCacheDecorator($repository, WEBED_BLOG_GROUP_CACHE_KEY);
            }

            return $repository;
        });
    }
}
