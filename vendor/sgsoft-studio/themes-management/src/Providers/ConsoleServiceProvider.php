<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->generatorCommands();
        $this->otherCommands();
    }

    protected function generatorCommands()
    {
        $this->commands([
            \WebEd\Base\ThemesManagement\Console\Generators\MakeTheme::class,
        ]);
    }

    protected function otherCommands()
    {
        $this->commands([
            \WebEd\Base\ThemesManagement\Console\Commands\EnableThemeCommand::class,
            \WebEd\Base\ThemesManagement\Console\Commands\DisableThemeCommand::class,
            \WebEd\Base\ThemesManagement\Console\Commands\InstallThemeCommand::class,
            \WebEd\Base\ThemesManagement\Console\Commands\UpdateThemeCommand::class,
            \WebEd\Base\ThemesManagement\Console\Commands\UninstallThemeCommand::class,
            \WebEd\Base\ThemesManagement\Console\Commands\GetAllThemesCommand::class,
        ]);
    }
}
