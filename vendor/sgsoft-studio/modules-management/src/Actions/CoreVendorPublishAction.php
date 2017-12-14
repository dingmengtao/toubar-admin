<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class CoreVendorPublishAction extends AbstractAction
{
    /**
     * @param $alias
     * @param array $params
     * @return array
     */
    public function run($alias, array $params)
    {
        $module = get_core_module($alias);

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        if (!$module || !class_exists($moduleProvider)) {
            return $this->error('Module not exists');
        }

        $this->publish($moduleProvider, $params);

        return $this->success('Your module assets has been published');
    }

    /**
     * @param $provider
     * @param $params
     */
    protected function publish($provider, $params)
    {
        $params = array_merge([
            '--provider' => $provider,
            '--force' => true,
        ], $params);

        Artisan::call('vendor:publish', $params);
    }
}
