<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;

class StageRepository extends EloquentBaseRepository implements StageRepositoryContract
{
    use EloquentUseSoftDeletes;

    /**
     * @param array $data
     * @return int
     */
    public function createStage(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateStage($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateStage($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteStage($id, $force = false)
    {
        return $this->delete($id, $force);
    }

    /**
     * @param array $params
     * @param bool $withTrash
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|Collection|mixed
     */
    public function getStages(array $params, $withTrash = false)
    {
        if ($withTrash) {
            $this->withTrashed();
        }

        return $this->advancedGet($params);
    }

}
