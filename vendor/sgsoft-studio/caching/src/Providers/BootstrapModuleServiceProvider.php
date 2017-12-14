<?php namespace WebEd\Base\Caching\Providers;

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
            'id' => 'webed-caching',
            'priority' => 2,
            'parent_id' => 'webed-configuration',
            'heading' => null,
            'title' => trans('webed-caching::base.admin_menu.caching'),
            'font_icon' => 'fa fa-circle-o',
            'link' => route('admin::webed-caching.index.get'),
            'css_class' => null,
            'permissions' => ['view-cache'],
        ]);
    }
}
