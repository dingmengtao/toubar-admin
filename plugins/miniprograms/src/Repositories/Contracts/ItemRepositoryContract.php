<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Miniprograms\Models\Contracts\ItemModelContract;

interface ItemRepositoryContract
{
    /**
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function createItem(array $data, array $trades);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateItem($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function updateItem($id, array $data,array $trades);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteItem($id, $force = false);

    /**
     * @param ItemModelContract|int $model
     * @return array
     */
    public function getRelatedTradeIds($model);

}
