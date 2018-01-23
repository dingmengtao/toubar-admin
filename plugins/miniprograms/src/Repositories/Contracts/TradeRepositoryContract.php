<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface TradeRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createTrade(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateTrade($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateTrade($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteTrade($id, $force = false);
}
