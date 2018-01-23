<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface ItemRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createItem(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateItem($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateItem($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteItem($id, $force = false);
}
