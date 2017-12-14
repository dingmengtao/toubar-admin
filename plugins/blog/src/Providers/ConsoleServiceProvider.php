<?php namespace WebEd\Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use WebEd\Plugins\Blog\Console\Commands\GenerateSamplePostsCommand;
use WebEd\Plugins\Blog\Console\Commands\GenerateSampleTagsCommand;

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
            GenerateSamplePostsCommand::class,
            GenerateSampleTagsCommand::class,
        ]);
    }
}
