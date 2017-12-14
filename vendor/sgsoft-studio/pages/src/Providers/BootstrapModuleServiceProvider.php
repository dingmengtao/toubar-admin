<?php namespace WebEd\Base\Pages\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Base\Events\SessionStarted;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

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
        admin_bar()->registerLink(trans('webed-pages::base.page'), route('admin::pages.create.get'), 'add-new');

        admin_quick_link()->register('page', [
            'title' => trans('webed-pages::base.page'),
            'url' => route('admin::pages.create.get'),
            'icon' => 'icon-notebook',
        ]);

        add_new_template([
            'homepage' => 'Homepage',
        ], WEBED_PAGES);

        $this->registerMenu();
        $this->registerMenuDashboard();
        $this->registerSettings();
        $this->registerPagesFields();
    }

    protected function registerMenuDashboard()
    {
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-pages',
            'priority' => 1,
            'parent_id' => null,
            'heading' => trans('webed-pages::base.admin_menu.pages.heading'),
            'title' => trans('webed-pages::base.admin_menu.pages.title'),
            'font_icon' => 'icon-notebook',
            'link' => route('admin::pages.index.get'),
            'css_class' => null,
            'permissions' => ['view-pages'],
        ]);
    }

    protected function registerMenu()
    {
        /**
         * Register menu widget
         */
        menus_management()
            ->registerWidget(trans('webed-pages::base.admin_menu.pages.title'), 'page', function () {
                $repository = app(PageRepositoryContract::class)
                    ->advancedGet([
                        'condition' => [
                            'status' => 1,
                        ],
                        'order_by' => [
                            'order' => 'ASC'
                        ],
                        'select' => ['id', 'title'],
                    ]);

                $pages = [];

                foreach ($repository as $page) {
                    $pages[] = [
                        'id' => $page->id,
                        'title' => $page->title,
                    ];
                }
                return $pages;
            });

        /**
         * Register menu link type
         */
        menus_management()->registerLinkType('page', function ($id) {
            $page = app(PageRepositoryContract::class)
                ->findWhere([
                    'status' => 1,
                    'id' => $id,
                ]);
            if (!$page) {
                return null;
            }
            return [
                'model_title' => $page->title,
                'url' => get_page_link($page),
            ];
        });
    }

    protected function registerSettings()
    {
        cms_settings()
            ->addSettingField('default_homepage', [
                'group' => 'basic',
                'type' => 'select',
                'priority' => 0,
                'label' => trans('webed-pages::base.settings.default_homepage.label'),
                'helper' => trans('webed-pages::base.settings.default_homepage.helper')
            ], function () {
                /**
                 * @var PageRepository $pageRepo
                 */
                $pageRepo = app(PageRepositoryContract::class);

                $pages = $pageRepo->advancedGet([
                    'condition' => [
                        'status' => 1,
                    ],
                    'order' => [
                        'order' => 'ASC',
                        'created_at' => 'DESC',
                    ],
                ]);

                $pagesArr = [];

                foreach ($pages as $page) {
                    $pagesArr[$page->id] = $page->title;
                }

                return [
                    'default_homepage',
                    $pagesArr,
                    get_setting('default_homepage'),
                    ['class' => 'form-control']
                ];
            });
    }

    protected function registerPagesFields()
    {
        CustomFieldSupportFacade::registerRule('basic', trans('webed-custom-fields::rules.page_template'), 'page_template', function () {
            return get_templates(WEBED_PAGES);
        })
            ->registerRule('basic', trans('webed-custom-fields::rules.page'), 'page', function () {
                return get_pages([
                    'select' => [
                        'id', 'title'
                    ],
                    'order_by' => [
                        'order' => 'ASC',
                        'created_at' => 'DESC',
                    ],
                ])
                    ->pluck('title', 'id')
                    ->toArray();
            })
            ->registerRule('other', trans('webed-custom-fields::rules.model_name'), 'model_name', function () {
                return [
                    WEBED_PAGES => trans('webed-custom-fields::rules.model_name_page'),
                ];
            });
    }
}
