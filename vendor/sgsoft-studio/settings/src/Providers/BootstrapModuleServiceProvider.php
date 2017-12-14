<?php namespace WebEd\Base\Settings\Providers;

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
        dashboard_menu()->registerItem([
            'id' => 'webed-settings',
            'priority' => 1,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => trans('webed-settings::base.admin_menu.title'),
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
            'permissions' => ['view-settings'],
        ]);
    }
}
