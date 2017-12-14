<?php namespace WebEd\Base\ThemesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class UpdateThemeAction extends AbstractAction
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    public function __construct()
    {
        $this->app = app();
    }

    public function run($alias)
    {
        do_action(WEBED_THEME_BEFORE_UPDATE, $alias);

        $theme = get_theme_information($alias);

        if (!$theme) {
            return $this->error('Theme not exists');
        }

        if (array_get($theme, 'version') === array_get($theme, 'installed_version')) {
            return $this->error("Theme " . $alias . " already up to date");
        }

        $namespace = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\UpdateModuleServiceProvider');
        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        save_theme_information($theme, [
            'installed_version' => array_get($theme, 'version'),
        ]);

        $themeProvider = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\ModuleProvider');

        Artisan::call('vendor:publish', [
            '--provider' => $themeProvider,
            '--tag' => 'webed-public-assets',
            '--force' => true
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_THEME_UPDATED, $alias);

        return $this->success('Your theme has been updated');
    }
}
