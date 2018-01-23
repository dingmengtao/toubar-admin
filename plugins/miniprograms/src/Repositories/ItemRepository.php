<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;

class ItemRepository extends EloquentBaseRepository implements ItemRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createItem(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateItem($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateItem($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteItem($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
