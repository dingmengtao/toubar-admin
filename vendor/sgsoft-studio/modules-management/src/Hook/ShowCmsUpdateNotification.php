<?php namespace WebEd\Base\ModulesManagement\Hook;


class ShowCmsUpdateNotification
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected $modules;

    public function __construct()
    {
        $this->modules = get_core_module();
    }

    public function handle()
    {
        if (!is_admin_panel()) {
            return;
        }

        $needToUpdate = 0;
        foreach ($this->modules as $module) {
            if (
                get_core_module_version($module['alias']) === array_get($module, 'installed_version')
                || !module_version_compare(get_core_module_version($module['alias']), '^' . array_get($module, 'installed_version', 0))
            ) {
                continue;
            }
            $needToUpdate++;
        }
        if ($needToUpdate) {
            echo html()->note(view('webed-modules-management::admin.update-cms.message', ['modulesCount' => $needToUpdate]), 'warning', false);
        }
    }
}
