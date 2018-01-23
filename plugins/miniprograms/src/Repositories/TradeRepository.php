<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\TradeRepositoryContract;

class TradeRepository extends EloquentBaseRepository implements TradeRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createTrade(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateTrade($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateTrade($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteTrade($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
