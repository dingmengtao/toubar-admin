<?php namespace DummyNamespace\Providers;

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
        /*dashboard_menu()->registerItem([
            'id' => 'DummyAlias',
            'priority' => 20,
            'parent_id' => null,
            'heading' => null,
            'title' => 'DummyName',
            'font_icon' => 'icon-puzzle',
            'link' => '',
            'css_class' => null,
            'permissions' => [],
        ]);*/
    }
}
