<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use WebEd\Base\Actions\AbstractAction;

class UpdatePluginAction extends AbstractAction
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
        do_action(WEBED_PLUGIN_BEFORE_UPDATE, $alias);

        DB::beginTransaction();

        $module = get_plugin($alias);

        if (!$module) {
            return $this->error('Plugin not exists');
        }

        if (array_get($module, 'version') === array_get($module, 'installed_version')) {
            return $this->error("Plugin " . $alias . " already up to date");
        }

        $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\UpdateModuleServiceProvider');
        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        webed_plugins()
            ->savePlugin($module, [
                'installed_version' => array_get($module, 'version'),
            ]);

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        DB::commit();

        Artisan::call('vendor:publish', [
            '--provider' => $moduleProvider,
            '--tag' => 'webed-public-assets',
            '--force' => true
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_PLUGIN_UPDATED, $alias);

        return $this->success('Your plugin has been updated');
    }
}
