<?php namespace WebEd\Plugins\Blog\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use WebEd\Base\Repositories\Traits\EloquentUseSoftDeletesCache;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class CategoryRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements CategoryRepositoryContract
{
    use EloquentUseSoftDeletesCache;

    /**
     * @param $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param bool $justId
     * @return array
     */
    public function getChildren($id, $justId = true)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @return Category
     */
    public function getParent($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @return int
     */
    public function createCategory(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCategory($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCategory($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $params
     * @param bool $withTrash
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function getCategories(array $params, $withTrash = false)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
