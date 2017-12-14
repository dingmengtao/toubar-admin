<?php namespace WebEd\Base\Menu\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\Events\SessionStarted;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;

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
            'id' => 'webed-menus',
            'priority' => 20,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-menus::base.menus'),
            'font_icon' => 'fa fa-bars',
            'link' => route('admin::menus.index.get'),
            'css_class' => null,
            'permissions' => ['view-menus']
        ]);

        cms_settings()
            ->addSettingField('main_menu', [
                'group' => 'basic',
                'type' => 'select',
                'priority' => 3,
                'label' => trans('webed-menus::base.settings.main_menu.label'),
                'helper' => trans('webed-menus::base.settings.main_menu.helper'),
            ], function () {
                $menus = app(MenuRepositoryContract::class)
                    ->getWhere(['status' => 1], ['slug', 'title'])
                    ->pluck('title', 'slug')
                    ->toArray();

                return [
                    'main_menu',
                    $menus,
                    get_setting('main_menu'),
                    ['class' => 'form-control']
                ];
            });

        admin_quick_link()->register('menu', [
            'title' => trans('webed-menus::base.menu'),
            'url' => route('admin::menus.create.get'),
            'icon' => 'fa fa-bars',
        ]);
    }
}
