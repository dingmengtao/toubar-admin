<?php namespace WebEd\Base\Pages\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Pages\Models\Page;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;
use WebEd\Base\Pages\Repositories\PageRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PageRepositoryContract::class, function () {
            $repository = new PageRepository(new Page());

            if (config('webed-caching.repository.enabled')) {
                return new PageRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
