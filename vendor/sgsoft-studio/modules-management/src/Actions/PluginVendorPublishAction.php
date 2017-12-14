<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class PluginVendorPublishAction extends CoreVendorPublishAction
{
    /**
     * @param $alias
     * @param array $params
     * @return array
     */
    public function run($alias, array $params)
    {
        $module = get_plugin($alias);

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        if (!$module || !class_exists($moduleProvider)) {
            return $this->error('Plugin not exists');
        }

        $this->publish($moduleProvider, $params);

        return $this->success('Your plugin assets has been published');
    }
}
