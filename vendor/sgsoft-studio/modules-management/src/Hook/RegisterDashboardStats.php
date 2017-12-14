<?php namespace WebEd\Base\ModulesManagement\Hook;


class RegisterDashboardStats
{
    protected $modules;

    protected $plugins;

    public function __construct()
    {
        $this->modules = get_core_module();
        $this->plugins = get_plugin();
    }

    public function handle()
    {
        echo view('webed-modules-management::admin.dashboard-stats.stat-box', [
            'count' => $this->plugins->count()
        ]);
    }
}
