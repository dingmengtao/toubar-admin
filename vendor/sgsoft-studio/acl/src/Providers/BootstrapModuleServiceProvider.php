<?php namespace WebEd\Base\ACL\Providers;

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
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-acl-roles',
            'priority' => 3.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-acl::base.roles'),
            'font_icon' => 'icon-lock',
            'link' => route('admin::acl-roles.index.get'),
            'css_class' => null,
            'permissions' => ['view-roles'],
        ])->registerItem([
            'id' => 'webed-acl-permissions',
            'priority' => 3.2,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-acl::base.permissions'),
            'font_icon' => 'icon-shield',
            'link' => route('admin::acl-permissions.index.get'),
            'css_class' => null,
            'permissions' => ['view-permissions'],
        ]);

        admin_quick_link()->register('role', [
            'title' => trans('webed-acl::base.role'),
            'url' => route('admin::acl-roles.create.get'),
            'icon' => 'icon-lock',
        ]);
    }
}
