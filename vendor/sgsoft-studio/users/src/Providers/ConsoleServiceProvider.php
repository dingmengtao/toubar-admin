<?php namespace WebEd\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Base\Users\Console\Commands\CreateSuperAdminUserCommand;
use WebEd\Base\Users\Console\Commands\ResetPasswordCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            ResetPasswordCommand::class,
            CreateSuperAdminUserCommand::class,
        ]);
    }
}
