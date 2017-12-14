<?php namespace WebEd\Base\ModulesManagement\Providers;

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
                'id' => 'webed-core-modules',
                'priority' => 1001,
                'parent_id' => null,
                'heading' => trans('webed-modules-management::base.admin_menu.core_modules.heading'),
                'title' => trans('webed-modules-management::base.admin_menu.core_modules.title'),
                'font_icon' => 'icon-rocket',
                'link' => route('admin::core-modules.index.get'),
                'css_class' => null,
                'permissions' => ['view-plugins'],
            ])
            ->registerItem([
                'id' => 'webed-plugins',
                'priority' => 1001.1,
                'parent_id' => null,
                'heading' => null,
                'title' => trans('webed-modules-management::base.admin_menu.plugins.title'),
                'font_icon' => 'icon-paper-plane',
                'link' => route('admin::plugins.index.get'),
                'css_class' => null,
                'permissions' => ['view-plugins'],
            ]);
    }
}
