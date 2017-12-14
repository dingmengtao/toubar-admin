<?php namespace WebEd\Base\Users\Providers;

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
            'id' => WEBED_USERS,
            'priority' => 3,
            'parent_id' => null,
            'heading' => trans('webed-users::base.admin_menu.heading'),
            'title' => trans('webed-users::base.admin_menu.title'),
            'font_icon' => 'icon-users',
            'link' => route('admin::users.index.get'),
            'css_class' => null,
            'permissions' => ['view-users'],
        ]);

        admin_quick_link()->register('user', [
            'title' => trans('webed-users::base.user'),
            'url' => route('admin::users.create.get'),
            'icon' => 'icon-users',
        ]);
    }
}
