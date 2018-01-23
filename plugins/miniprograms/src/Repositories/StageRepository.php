<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;

class StageRepository extends EloquentBaseRepository implements StageRepositoryContract
{
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
}
