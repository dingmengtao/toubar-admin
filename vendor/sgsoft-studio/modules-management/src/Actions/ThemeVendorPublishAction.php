<?php namespace WebEd\Base\ModulesManagement\Actions;

use Illuminate\Support\Facades\Artisan;
use WebEd\Base\Actions\AbstractAction;

class ThemeVendorPublishAction extends CoreVendorPublishAction
{
    /**
     * @param $alias
     * @param array $params
     * @return array
     */
    public function run($alias, array $params)
    {
        $module = get_theme_information($alias);

        $moduleProvider = str_replace('\\\\', '\\', array_get($module, 'namespace', '') . '\Providers\ModuleProvider');

        if (!$module || !class_exists($moduleProvider)) {
            return $this->error('Theme not exists');
        }

        $this->publish($moduleProvider, $params);

        return $this->success('Your theme assets has been published');
    }
}
