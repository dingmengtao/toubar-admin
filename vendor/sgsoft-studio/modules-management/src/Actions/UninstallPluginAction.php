<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use WebEd\Base\Actions\AbstractAction;

class UninstallPluginAction extends AbstractAction
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
        do_action(WEBED_PLUGIN_BEFORE_UNINSTALL, $alias);

        DB::beginTransaction();

        $module = get_plugin($alias);

        if (!$module) {
            return $this->error('Plugin not exists');
        }

        $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\UninstallModuleServiceProvider');

        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        webed_plugins()
            ->savePlugin($module, [
                'installed' => false,
                'installed_version' => '',
            ]);

        DB::commit();

        Artisan::call('cache:clear');

        do_action(WEBED_PLUGIN_AFTER_UNINSTALL, $alias);

        return $this->success('Your plugin has been uninstalled');
    }
}
