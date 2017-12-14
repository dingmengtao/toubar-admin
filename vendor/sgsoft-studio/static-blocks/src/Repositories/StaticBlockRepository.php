<?php namespace WebEd\Base\StaticBlocks\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;

class StaticBlockRepository extends EloquentBaseRepository implements StaticBlockRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createStaticBlock(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateStaticBlock($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateStaticBlock($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteStaticBlock($id)
    {
        return $this->delete($id);
    }
}
