<?php namespace WebEd\Base\ModulesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ModulesManagement\Models\CoreModules;
use WebEd\Base\ModulesManagement\Models\Plugins;
use WebEd\Base\ModulesManagement\Repositories\Contracts\CoreModuleRepositoryContract;
use WebEd\Base\ModulesManagement\Repositories\Contracts\PluginRepositoryContract;
use WebEd\Base\ModulesManagement\Repositories\CoreModuleRepository;
use WebEd\Base\ModulesManagement\Repositories\CoreModuleRepositoryCacheDecorator;
use WebEd\Base\ModulesManagement\Repositories\PluginRepository;
use WebEd\Base\ModulesManagement\Repositories\PluginRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PluginRepositoryContract::class, function () {
            $repository = new PluginRepository(new Plugins());

            if (config('webed-caching.repository.enabled')) {
                return new PluginRepositoryCacheDecorator($repository);
            }

            return $repository;
        });

        $this->app->bind(CoreModuleRepositoryContract::class, function () {
            $repository = new CoreModuleRepository(new CoreModules());

            if (config('webed-caching.repository.enabled')) {
                return new CoreModuleRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
