<?php namespace WebEd\Base\ModulesManagement\Actions;

use WebEd\Base\Actions\AbstractAction;

class UpdateCMSAction extends AbstractAction
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
     * @return array
     */
    public function run()
    {
        $modules = get_core_module();

        $updated = 0;

        foreach ($modules as $module) {
            if (get_core_module_composer_version(array_get($module, 'repos')) === array_get($module, 'installed_version')) {
                continue;
            }
            $this->app->make(UpdateCoreModuleAction::class)->run($module['alias']);
            $updated++;
        }
        if (!$updated) {
            $this->error('You have nothing to update');
        }

        return $this->success('CMS has been updated');
    }
}
