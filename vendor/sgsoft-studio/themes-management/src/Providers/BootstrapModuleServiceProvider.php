<?php namespace WebEd\Base\ThemesManagement\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Events\SessionStarted;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen(SessionStarted::class, function () {
            $this->onSessionStarted();
        });
    }

    /**
     * Register dashboard menus, translations, cms settings
     */
    protected function onSessionStarted()
    {
        dashboard_menu()
            ->registerItem([
                'id' => 'webed-themes-management',
                'priority' => 1002,
                'parent_id' => null,
                'heading' => null,
                'title' => trans('webed-themes-management::base.admin_menu.themes.title'),
                'font_icon' => 'icon-magic-wand',
                'link' => route('admin::themes.index.get'),
                'css_class' => null,
                'permissions' => ['view-themes'],
            ])
            ->registerItem([
                'id' => 'webed-theme-options',
                'priority' => 1002,
                'parent_id' => 'webed-configuration',
                'heading' => null,
                'title' => trans('webed-themes-management::base.admin_menu.theme_options.title'),
                'font_icon' => 'icon-settings',
                'link' => route('admin::theme-options.index.get'),
                'css_class' => null,
                'permissions' => ['view-theme-options'],
            ]);
    }
}
