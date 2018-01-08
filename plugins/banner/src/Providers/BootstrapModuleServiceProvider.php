<?php namespace WebEd\Plugins\Banner\Providers;

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
        //应用启动执行注册菜单项
        dashboard_menu()->registerItem([
            'id' => 'banner',
            'priority' => 20,
            'parent_id' => null,
            'heading' => 'Banner',//分组
            'title' => 'WebEd banner',//菜单名称
            'font_icon' => 'icon-puzzle',//菜单图标
            'link' => route('admin::banner.index.get'),//路由地址
            'css_class' => null,
            'permissions' => ['banner'],
        ]);

    }
}
