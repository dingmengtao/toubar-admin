<?php namespace WebEd\Base\ModulesManagement\Actions;

use WebEd\Base\Actions\AbstractAction;

class EnablePluginAction extends AbstractAction
{
    /**
     * @param $alias
     * @return array
     */
    public function run($alias)
    {
        do_action(WEBED_PLUGIN_BEFORE_ENABLE, $alias);

        $module = get_plugin($alias);

        if (!$module) {
            return $this->error('Plugin not exists');
        }

        $checkRelatedModules = check_module_require($module);
        if ($checkRelatedModules['error']) {
            $messages = [];
            foreach ($checkRelatedModules['messages'] as $message) {
                $messages[] = $message;
            }
            return $this->error($messages);
        }

        webed_plugins()->enableModule($alias);

        do_action(WEBED_PLUGIN_ENABLED, $alias);

        modules_management()->refreshComposerAutoload();

        return $this->success('Your plugin has been enabled');
    }
}
