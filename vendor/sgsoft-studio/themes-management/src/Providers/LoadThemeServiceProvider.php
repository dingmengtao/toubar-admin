<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\ServiceProvider;

class LoadThemeServiceProvider extends ServiceProvider
{
    protected $currentTheme;

    protected $themeProvider;

    protected $themeLoaded = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Callback when app booted
     *
     * @return void
     */
    protected function booted()
    {
        $this->currentTheme = get_current_theme();
        if(!$this->currentTheme) {
            $this->themeLoaded = true;

            return;
        }
        $this->themeProvider = array_get($this->currentTheme, 'namespace', '') . '\Providers\ModuleProvider';
        if (class_exists($this->themeProvider)) {
            $this->app->register($this->themeProvider);
            $this->themeLoaded = true;
        }

        if (!$this->themeLoaded && !app()->runningInConsole()) {
            /**
             * Use hook here
             * Show the error messages
             */
            add_action('flash_messages', function () {
                echo html()->note(
                    'This theme <b>' . array_get($this->currentTheme, 'name') . '</b> 
                    is enabled, but class not found: ' . $this->themeProvider . '. 
                    Please review and add the namespace of this theme to composer autoload section, then run 
                    <a href="' . route('admin::system.commands.composer-dump-autoload.get') . '">
                    <b>composer dump-autoload</b>
                    </a>',
                    'error',
                    false
                );
            }, 9999);
        }
    }
}
