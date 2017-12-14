<?php namespace WebEd\Base\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Models\EloquentBase;
use WebEd\Base\Repositories\AbstractBaseRepository;

/**
 * @property BaseModelContract|EloquentBase|Builder $model
 * @property BaseModelContract|EloquentBase|Builder $originalModel
 */
abstract class EloquentBaseRepository extends AbstractBaseRepository
{
    /**
     * @param array $where
     * @param null $model
     */
    protected function applyConditions(array $where, &$model = null)
    {
        if (!$model) {
            $newModel = $this->model;
        } else {
            $newModel = $model;
        }
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $newModel = $newModel->whereIn($field, $val);
                        break;
                    case 'NOT_IN':
                        $newModel = $newModel->whereNotIn($field, $val);
                        break;
                    default:
                        $newModel = $newModel->where($field, $condition, $val);
                        break;
                }
            } else {
                $newModel = $newModel->where($field, '=', $value);
            }
        }
        if (!$model) {
            $this->model = $newModel;
        } else {
            $model = $newModel;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        $this->applyCriteria();

        $result = $this->model->count();

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function first(array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->model->first($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * @param int $id
     * @param array $columns
     * @return EloquentBase|Builder|null
     */
    public function find($id, $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->model->find($id, $columns);

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $condition
     * @param array $columns
     * @return EloquentBase|Builder|null|mixed
     */
    public function findWhere(array $condition, array $columns = ['*'])
    {
        $this->applyCriteria();

        $this->applyConditions($condition);
        $result = $this->model
            ->select($columns)
            ->first();

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $condition
     * @param array $optionalFields
     * @param bool $forceCreate
     * @return EloquentBase|Builder|null
     */
    public function findWhereOrCreate(array $condition, array $optionalFields = [], $forceCreate = false)
    {
        $result = $this->findWhere($condition);
        if (!$result) {
            $data = array_merge((array)$optionalFields, $condition);

            $fieldsToCreate = [];

            foreach ($data as $key => $value) {
                if (!is_array($value)) {
                    $fieldsToCreate[$key] = $value;
                }
            }

            $id = $this->create($fieldsToCreate);
            $result = $this->find($id);
        }
        $this->resetModel();
        return $result;
    }

    /**
     * @param int $id
     * @return EloquentBase|Builder
     */
    public function findOrNew($id)
    {
        $result = $this->model->find($id) ?: new $this->originalModel;

        $this->resetModel();

        return $result;
    }

    /**
     * @param int $id
     * @return EloquentBase|Builder
     */
    public function firstOrNew(array $condition)
    {
        $this->applyConditions($condition);

        $result = $this->model->first() ?: new $this->originalModel;

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function get(array $columns = ['*'])
    {
        $this->applyCriteria();

        $result = $this->model->get($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $condition
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWhere(array $condition, array $columns = ['*'])
    {
        $this->applyCriteria();

        $this->applyConditions($condition);

        $result = $this->model->get($columns);

        $this->resetModel();

        return $result;
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @param int $currentPaged
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, array $columns = ['*'], $currentPaged = 1)
    {
        $this->applyCriteria();

        $result = $this->model->paginate($perPage, $columns, 'page', $currentPaged);

        $this->resetModel();

        return $result;
    }

    /**
     * @param array $data
     * @param bool $force
     * @return int|null|EloquentBase
     */
    public function create(array $data, $force = false)
    {
        $method = $force ? 'forceCreate' : 'create';

        $item = $this->model->$method($data);

        $primaryKey = $this->getPrimaryKey();

        return $item->$primaryKey ?: $item;
    }

    /**
     * @param EloquentBase|Builder|int|null $id
     * @param array $data
     * @return int|null|EloquentBase
     */
    public function createOrUpdate($id, array $data)
    {
        /**
         * @var EloquentBase|Builder $item
         */
        $item = $id instanceof EloquentBase ? $id : $this->model->find($id) ?: new $this->model;

        $item = $item->fill($data);

        if (!$item->save()) {
            return null;
        }

        $primaryKey = $this->getPrimaryKey();

        return $item->$primaryKey ?: $item;
    }

    /**
     * @param EloquentBase|Builder|int $id
     * @param array $data
     * @return int|null|EloquentBase
     */
    public function update($id, array $data)
    {
        if ($id instanceof EloquentBase) {
            $item = $id;
        } else {
            $item = $this->model->find($id);
        }

        $result = $item->update($data);

        $this->resetModel();

        if (!$result) {
            return null;
        }

        $primaryKey = $this->getPrimaryKey();

        return $item->$primaryKey ?: $item;
    }

    /**
     * @param array $ids
     * @param array $data
     * @return bool
     */
    public function updateMultiple(array $ids, array $data)
    {
        $items = $this->model->whereIn('id', $ids);

        $result = $items->update($data);

        $this->resetModel();

        return $result;
    }

    /**
     * @param EloquentBase|Builder|int|array|null $id
     * @param bool $force
     * @return bool
     */
    public function delete($id, $force = false)
    {
        if ($id) {
            if (is_array($id)) {
                $this->model = $this->model->whereIn('id', $id);
            } elseif ($id instanceof EloquentBase) {
                $this->model = $id;
            } else {
                $this->model = $this->model->where('id', '=', $id);
            }
        } else {
            $this->applyCriteria();
        }

        $method = $force ? 'forceDelete' : 'delete';

        $result = $this->model->$method();

        $this->resetModel();

        return !!$result;
    }

    /**
     * @param array $condition
     * @param bool $force
     * @return bool
     */
    public function deleteWhere(array $condition, $force = false)
    {
        $this->applyConditions($condition);

        $method = $force ? 'forceDelete' : 'delete';

        $result = $this->model->$method();

        $this->resetModel();

        return !!$result;
    }

    /**
     * @param array $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function advancedGet(array $params = [])
    {
        $params = array_merge([
            'condition' => [],
            'order_by' => [],
            'take' => null,
            'paginate' => [
                'per_page' => null,
                'current_paged' => 1
            ],
            'select' => ['*'],
            'with' => [],
            'criteria' => [],
        ], $params);

        $criteria = array_get($params, 'criteria');

        foreach ($criteria as $criterion) {
            $this->pushCriteria($criterion);
        }

        $this->applyCriteria();

        $this->applyConditions($params['condition']);

        if ($params['select']) {
            $this->model = $this->model->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            $this->model = $this->model->orderBy($column, $direction);
        }

        foreach ($params['with'] as $with) {
            $this->model = $this->model->with($with);
        }

        if ($params['take'] == 1) {
            $result = $this->model->first();
        } elseif ($params['take']) {
            $result = $this->model->take($params['take'])->get();
        } elseif ($params['paginate']['per_page']) {
            $result = $this->model->paginate(
                $params['paginate']['per_page'],
                [$this->originalModel->getTable() . '.' . $this->originalModel->getPrimaryKey()],
                'page',
                $params['paginate']['current_paged']
            );
        } else {
            $result = $this->model->get();
        }

        $this->resetModel();

        return $result;
    }
}
