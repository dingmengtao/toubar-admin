<?php namespace WebEd\Base\ThemesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class InstallThemeAction extends AbstractAction
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
        do_action(WEBED_THEME_BEFORE_INSTALL, $alias);

        $theme = get_theme_information($alias);

        if (!$theme) {
            return $this->error('Theme not exists');
        }

        if (array_get($theme, 'installed') === true) {
            return $this->error("Theme " . $alias . " installed already.");
        }

        $checkRelatedModules = check_module_require($theme);
        if ($checkRelatedModules['error']) {
            $messages = [];
            foreach ($checkRelatedModules['messages'] as $message) {
                $messages[] = $message;
            }
            return $this->error($messages);
        }

        $namespace = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\InstallModuleServiceProvider');
        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        $themeProvider = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\ModuleProvider');

        Artisan::call('vendor:publish', [
            '--provider' => $themeProvider,
            '--tag' => 'webed-public-assets',
            '--force' => true
        ]);

        save_theme_information($theme, [
            'installed' => true,
            'installed_version' => array_get($theme, 'version'),
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_THEME_AFTER_INSTALL, $alias);

        return $this->success('Your theme has been installed');
    }
}
