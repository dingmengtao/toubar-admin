<?php namespace WebEd\Base\Pages\Repositories;

use WebEd\Base\Pages\Models\Page;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Repositories\Traits\EloquentUseSoftDeletesCache;

class PageRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements PageRepositoryContract
{
    use EloquentUseSoftDeletesCache;

    /**
     * @param array $data
     * @return int
     */
    public function createPage(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Page|int $id
     * @param array $data
     * @return int
     */
    public function updatePage($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|array $ids
     * @param bool $force
     * @return bool
     */
    public function deletePage($ids, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPages(array $params)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
