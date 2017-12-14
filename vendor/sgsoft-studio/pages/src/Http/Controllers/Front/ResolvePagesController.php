<?php namespace WebEd\Base\Pages\Http\Controllers\Front;

use WebEd\Base\Http\Controllers\BaseFrontController;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class ResolvePagesController extends BaseFrontController
{
    /**
     * @var PageRepositoryContract|PageRepository
     */
    protected $repository;

    /**
     * SlugWithoutSuffixController constructor.
     * @param PageRepository $repository
     */
    public function __construct(PageRepositoryContract $repository)
    {
        parent::__construct();

        $this->themeController = themes_management()->getThemeController('Pages\Page');

        if (!$this->themeController) {
            echo 'You need to active a theme';
            die();
        }

        if (is_string($this->themeController)) {
            echo 'Class ' . $this->themeController . ' not exists';
            die();
        }

        $this->repository = $repository;
    }

    public function handle($slug = null)
    {
        $slug = $this->request->route()->parameter('slug') ?: $slug;

        if(!$slug) {
            $page = $this->repository
                ->findWhere([
                    'id' => do_filter('front.default-homepage.get', get_setting('default_homepage')),
                    'status' => 1
                ]);
        } else {
            $page = $this->repository
                ->findWhere([
                    'slug' => $slug,
                    'status' => 1
                ]);
        }

        $page = do_filter(FRONT_FILTER_FIND_DATA, $page, WEBED_PAGES);

        if(!$page) {
            if ($slug === null) {
                echo '<h2>You need to setup your default homepage. Create a page then go through to Admin Dashboard -> Configuration -> Settings</h2>';
                die();
            } else {
                abort(404);
            }
        }

        /**
         * Update view count
         */
        increase_view_count(WEBED_PAGES, $page->id);

        seo()
            ->metaDescription($page->description)
            ->metaImage($page->thumbnail)
            ->metaKeywords($page->keywords)
            ->setModelObject($page);

        admin_bar()->registerLink(trans('webed-pages::base.admin_bar'), route('admin::pages.edit.get', ['id' => $page->id]));

        $this->setPageTitle($page->title);

        $this->dis['object'] = $page;

        return $this->themeController->handle($page, $this->dis);
    }
}
