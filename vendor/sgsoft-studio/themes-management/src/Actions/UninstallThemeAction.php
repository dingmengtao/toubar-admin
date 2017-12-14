<?php namespace WebEd\Base\ThemesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class UninstallThemeAction extends AbstractAction
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    public function __construct()
    {
        $this->app = app();
    }

    /**
     * @param $alias
     * @return array
     */
    public function run($alias)
    {
        do_action(WEBED_THEME_BEFORE_UNINSTALL, $alias);

        $theme = get_theme_information($alias);

        if (!$theme) {
            return $this->error('Plugin not exists');
        }

        $namespace = str_replace('\\\\', '\\', array_get($theme, 'namespace', '') . '\Providers\UninstallModuleServiceProvider');

        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        save_theme_information($theme, [
            'installed' => false,
            'installed_version' => '',
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_THEME_AFTER_UNINSTALL, $alias);

        return $this->success('Your theme has been uninstalled');
    }
}
