<?php namespace WebEd\Base\StaticBlocks\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\StaticBlocks\Models\StaticBlock;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StaticBlockRepositoryContract::class, function () {
            $repository = new StaticBlockRepository(new StaticBlock());

            if (config('webed-caching.repository.enabled')) {
                return new StaticBlockRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
