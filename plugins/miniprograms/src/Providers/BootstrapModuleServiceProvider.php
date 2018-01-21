<?php namespace WebEd\Plugins\Miniprograms\Providers;

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
            'id' => WEBED_MINIPROGRAMS,
            'priority' => 20,
            'parent_id' => null,
            'heading' => '微信小程序',
            'title' => 'toubar',
//            'font_icon' => 'icon-puzzle',
            'font_icon' => 'icon-program',
            'link' => route('admin::miniprograms.toubar.index.get'),
            'css_class' => null,
            'permissions' => [],
        ]);
    }
}
