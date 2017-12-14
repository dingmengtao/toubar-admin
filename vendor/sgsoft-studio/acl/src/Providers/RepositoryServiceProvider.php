<?php namespace WebEd\Base\ACL\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\ACL\Models\Permission;
use WebEd\Base\ACL\Models\Role;
use WebEd\Base\ACL\Repositories\Contracts\PermissionRepositoryContract;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\PermissionRepository;
use WebEd\Base\ACL\Repositories\PermissionRepositoryCacheDecorator;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\ACL\Repositories\RoleRepositoryCacheDecorator;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RoleRepositoryContract::class, function () {
            $repository = new RoleRepository(new Role);

            if (config('webed-caching.repository.enabled')) {
                return new RoleRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
        $this->app->bind(PermissionRepositoryContract::class, function () {
            $repository = new PermissionRepository(new Permission);

            if (config('webed-caching.repository.enabled')) {
                return new PermissionRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
