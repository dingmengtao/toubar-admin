<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Models\PasswordReset;
use WebEd\Base\Users\Models\User;
use WebEd\Base\Users\Repositories\Contracts\PasswordResetRepositoryContract;
use WebEd\Base\Users\Repositories\PasswordResetRepository;
use WebEd\Base\Users\Repositories\UserRepository;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(PasswordResetRepositoryContract::class, function () {
            return new PasswordResetRepository(new PasswordReset());
        });
    }
}
