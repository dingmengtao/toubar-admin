<?php namespace WebEd\Base\ThemesManagement\Actions;

use WebEd\Base\Actions\AbstractAction;

class EnableThemeAction extends AbstractAction
{
    /**
     * @param $alias
     * @return array
     */
    public function run($alias)
    {
        do_action(WEBED_THEME_BEFORE_ENABLE, $alias);

        $theme = get_theme_information($alias);

        if (!$theme) {
            return $this->error('Plugin not exists');
        }

        $checkRelatedModules = check_module_require($theme);
        if ($checkRelatedModules['error']) {
            $messages = [];
            foreach ($checkRelatedModules['messages'] as $message) {
                $messages[] = $message;
            }
            return $this->error($messages);
        }

        themes_management()->enableTheme($alias);

        do_action(WEBED_THEME_ENABLED, $alias);

        modules_management()->refreshComposerAutoload();

        return $this->success('Your theme has been enabled');
    }
}
