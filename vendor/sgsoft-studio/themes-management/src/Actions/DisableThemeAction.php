<?php namespace WebEd\Base\ThemesManagement\Actions;

use WebEd\Base\Actions\AbstractAction;

class DisableThemeAction extends AbstractAction
{
    /**
     * @param $alias
     * @return array
     */
    public function run($alias)
    {
        do_action(WEBED_THEME_BEFORE_DISABLE, $alias);

        themes_management()->disableTheme($alias);

        do_action(WEBED_THEME_DISABLED, $alias);

        modules_management()->refreshComposerAutoload();

        return $this->success('Your theme has been disabled');
    }
}
