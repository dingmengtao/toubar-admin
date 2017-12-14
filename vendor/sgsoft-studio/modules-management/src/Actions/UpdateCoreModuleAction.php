<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use WebEd\Base\Actions\AbstractAction;

class UpdateCoreModuleAction extends AbstractAction
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
        do_action(WEBED_CORE_BEFORE_UPDATE, $alias);

        DB::beginTransaction();

        $module = get_core_module($alias);

        if (!$module) {
            return $this->error('Module not exists');
        }

        if (get_core_module_composer_version(array_get($module, 'repos')) === array_get($module, 'installed_version')) {
            return $this->error("Module " . $alias . " already up to date");
        }

        $namespace = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\UpdateModuleServiceProvider');

        if (class_exists($namespace)) {
            $this->app->register($namespace);
        }

        webed_core_modules()
            ->saveModule($module, [
                'installed_version' => isset($module['version']) ? $module['version'] : get_core_module_composer_version(array_get($module, 'repos')),
            ]);

        DB::commit();

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        Artisan::call('vendor:publish', [
            '--provider' => $moduleProvider,
            '--tag' => 'webed-public-assets',
            '--force' => true
        ]);

        Artisan::call('cache:clear');

        do_action(WEBED_CORE_UPDATED, $alias);

        return $this->success('Module ' . $alias . ' has been updated');
    }
}
