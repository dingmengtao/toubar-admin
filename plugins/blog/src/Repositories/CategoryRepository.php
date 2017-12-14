<?php namespace WebEd\Plugins\Blog\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Blog\Models\Category;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

/**
 * @property Category|Builder $model
 */
class CategoryRepository extends EloquentBaseRepository implements CategoryRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Category) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        return array_unique($result);
    }

    /**
     * @param $id
     * @param bool $justId
     * @return array
     */
    public function getChildren($id, $justId = true)
    {
        if ($id instanceof Category) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }
        if (!$model) {
            return null;
        }

        $children = $model->children();
        if ($justId) {
            return $children->select('id')->get()->pluck('id');
        }
        $children = $children->get();
        $result = [];
        foreach ($children as $child) {
            $result[] = $child;
        }
        return $result;
    }

    /**
     * @param $id
     * @return Category
     */
    public function getParent($id)
    {
        if ($id instanceof Category) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }
        if (!$model) {
            return null;
        }

        return $model->parent()->first();
    }

    /**
     * @param array $data
     * @return int
     */
    public function createCategory(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCategory($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCategory($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCategory($id)
    {
        return $this->delete($id);
    }

    /**
     * @param array $params
     * @param bool $withTrash
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function getCategories(array $params, $withTrash = false)
    {
        if ($withTrash) {
            $this->withTrashed();
        }

        return $this->advancedGet($params);
    }
}
