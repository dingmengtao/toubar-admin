<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class ItemRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements ItemRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createItem(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateItem($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateItem($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteItem($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
