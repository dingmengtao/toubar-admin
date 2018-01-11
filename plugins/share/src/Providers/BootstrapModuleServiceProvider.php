<?php namespace WebEd\Plugins\Share\Providers;

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
            'id' => WEBED_SHARE,
            'priority' => 20,
            'parent_id' => null,
            'heading' => 'Share',
            'title' => 'WebEd share',
            'font_icon' => 'icon-share',
            'link' => route('admin::share.share.index.get'),
            'css_class' => null,
//            'permissions' => [],
        ]);
    }
}
