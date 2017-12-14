<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ThemesManagement\Models\Theme;
use WebEd\Base\ThemesManagement\Models\ThemeOption;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeOptionRepositoryContract;
use WebEd\Base\ThemesManagement\Repositories\Contracts\ThemeRepositoryContract;
use WebEd\Base\ThemesManagement\Repositories\ThemeOptionRepository;
use WebEd\Base\ThemesManagement\Repositories\ThemeOptionRepositoryCacheDecorator;
use WebEd\Base\ThemesManagement\Repositories\ThemeRepository;
use WebEd\Base\ThemesManagement\Repositories\ThemeRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ThemeRepositoryContract::class, function () {
            $repository = new ThemeRepository(new Theme());

            if (config('webed-caching.repository.enabled')) {
                return new ThemeRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(ThemeOptionRepositoryContract::class, function () {
            $repository = new ThemeOptionRepository(new ThemeOption());

            if (config('webed-caching.repository.enabled')) {
                return new ThemeOptionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
