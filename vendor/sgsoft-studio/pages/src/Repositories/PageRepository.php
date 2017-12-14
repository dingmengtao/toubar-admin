<?php namespace WebEd\Base\Pages\Repositories;

use WebEd\Base\Pages\Models\Page;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Pages\Repositories\Contracts\PageRepositoryContract;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;

class PageRepository extends EloquentBaseRepository implements PageRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param array $data
     * @return int
     */
    public function createPage(array $data)
    {
        return $this->create($data, true);
    }

    /**
     * @param Page|int $id
     * @param array $data
     * @return int
     */
    public function updatePage($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|array $ids
     * @param bool $force
     * @return bool
     */
    public function deletePage($ids, $force = false)
    {
        return $this->delete((array)$ids, $force);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getPages(array $params)
    {
        return $this->advancedGet($params);
    }
}
