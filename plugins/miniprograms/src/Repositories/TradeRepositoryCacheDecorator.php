<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class TradeRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements TradeRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createTrade(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateTrade($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateTrade($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteTrade($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
