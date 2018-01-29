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
            'id' => WEBED_TOUBAR,
            'priority' => 10.1,
            'parent_id' => null,
            'heading' => '微信小程序',
            'title' => '投扒',
            'font_icon' => 'fa fa-sitemap',
            'link' => route('admin::miniprograms.toubar.user.index.get'),
            'css_class' => null,
            'permissions' => [],
        ])->registerItem([
            'id' => WEBED_TEST,
            'priority' => 10.2,
            'parent_id' => null,
            'title' => '测试',
            'font_icon' => 'fa fa-sitemap',
            'link' => route('admin::miniprograms.toubar.user.index.get'),
            'css_class' => null,
            'permissions' => [],
        ])->registerItem([
            'id' => WEBED_TOUBAR_USER,
            'priority' => 10.1-1,
            'parent_id' => WEBED_TOUBAR,
            'title' => '用户',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::miniprograms.toubar.user.index.get'),
            'css_class' => null,
            'permissions' => ['view-user'],
        ])->registerItem([
            'id' => WEBED_TOUBAR_INVESTOR,
            'priority' => 10.1-2,
            'parent_id' => WEBED_TOUBAR,
            'title' => '投资人',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::miniprograms.toubar.investor.index.get'),
            'css_class' => null,
            'permissions' => ['view-investor'],
        ])->registerItem([
            'id' => WEBED_TOUBAR_ITEM,
            'priority' => 10.1-3,
            'parent_id' => WEBED_TOUBAR,
            'title' => '项目',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::miniprograms.toubar.item.index.get'),
            'css_class' => null,
            'permissions' => ['view-item'],
        ])->registerItem([
            'id' => WEBED_TOUBAR_STAGE,
            'priority' => 10.1-4,
            'parent_id' => WEBED_TOUBAR,
            'title' => '阶段',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::miniprograms.toubar.stage.index.get'),
            'css_class' => null,
            'permissions' => ['view-stage'],
        ])->registerItem([
            'id' => WEBED_TOUBAR_TRADE,
            'priority' => 10.1-5,
            'parent_id' => WEBED_TOUBAR,
            'title' => '行业',
            'font_icon' => 'icon-puzzle',
            'link' => route('admin::miniprograms.toubar.trade.index.get'),
            'css_class' => null,
            'permissions' => ['view-trade'],
        ]);
    }
}
