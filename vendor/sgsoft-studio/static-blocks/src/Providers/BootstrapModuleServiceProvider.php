<?php namespace WebEd\Base\StaticBlocks\Providers;

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
            'id' => 'webed-static-blocks',
            'priority' => 1.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-static-blocks::base.admin_menu.title'),
            'font_icon' => 'fa fa-server',
            'link' => route('admin::static-blocks.index.get'),
            'css_class' => null,
            'permissions' => ['has-permission:view-static-blocks'],
        ]);
    }
}
