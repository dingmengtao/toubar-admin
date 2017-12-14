<?php namespace WebEd\Base\ThemesManagement\Hook;


class RegisterDashboardStats
{
    protected $themes;

    protected $activated;

    public function __construct()
    {
        $this->themes = collect(get_all_theme_information());
        $this->activated = $this->themes->where('enabled', true)->first();
    }

    public function handle()
    {
        echo view('webed-themes-management::admin.dashboard-stats.stat-box', [
            'count' => $this->themes->count(),
            'activatedTheme' => $this->activated ?: [],
        ]);
    }
}
