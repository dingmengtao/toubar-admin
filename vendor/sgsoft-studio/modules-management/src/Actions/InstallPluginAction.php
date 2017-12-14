<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use WebEd\Base\Actions\AbstractAction;

class InstallPluginAction extends AbstractAction
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
        do_action(WEBED_PLUGIN_BEFORE_INSTALL, $alias);

        DB::beginTransaction();

        $module = get_plugin($alias);

        if (!$module) {
            return $this->error('Plugin not exists');
        }

        if (array_get($module, 'installed') === true) {
            return $this->error("Plugin " . $alias . " installed already.");
        }

        $checkRelatedModules = check_module_require($module);
        if ($checkRelatedModules['error']) {
            $messages = [];
            foreach ($checkRelatedModules['messages'] as $message) {
                $messages[] = $message;
            }
            return $this->error($messages);
        }

        $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\InstallModuleServiceProvider');
        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        webed_plugins()
            ->savePlugin($module, [
                'installed' => true,
                'installed_version' => array_get($module, 'version'),
            ]);

        DB::commit();

        Artisan::call('vendor:publish', [
            '--provider' => $moduleProvider,
            '--tag' => 'webed-public-assets',
            '--force' => true
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_PLUGIN_AFTER_INSTALL, $alias);

        return $this->success('Your plugin has been installed');
    }
}
