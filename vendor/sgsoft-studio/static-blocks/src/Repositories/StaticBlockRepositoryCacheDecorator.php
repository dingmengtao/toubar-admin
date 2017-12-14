<?php namespace WebEd\Base\StaticBlocks\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class StaticBlockRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements StaticBlockRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createStaticBlock(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateStaticBlock($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateStaticBlock($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteStaticBlock($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
