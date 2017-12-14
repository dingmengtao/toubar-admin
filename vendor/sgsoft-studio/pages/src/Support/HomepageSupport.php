<?php namespace WebEd\Base\Pages\Support;

use WebEd\Base\Pages\Models\Contracts\PageModelContract;
use WebEd\Base\Pages\Models\Page;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Pages\Repositories\PageRepository;

class HomepageSupport
{
    /**
     * @var Page|PageModelContract
     */
    protected $homepage;

    /**
     * @var PageRepository
     */
    protected $repository;

    public function __construct(PageRepositoryContract $pageRepository)
    {
        $this->repository = $pageRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|null|\WebEd\Base\Models\Contracts\BaseModelContract|\WebEd\Base\Models\EloquentBase
     */
    public function getHomepage()
    {
        $setting = get_setting('default_homepage');

        if ($this->homepage || !$setting) {
            return null;
        }

        $page = $this->repository->find($setting);

        if ($page) {
            return $this->homepage = $page;
        }

        return null;
    }

    /**
     * @param $default
     * @return string
     */
    public function getHomepageLink($default)
    {
        $this->getHomepage();

        if (!$this->homepage) {
            return $default;
        }

        return get_page_link($this->homepage->slug);
    }
}
