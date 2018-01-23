<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\StageRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class StageRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements StageRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createStage(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateStage($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateStage($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteStage($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
