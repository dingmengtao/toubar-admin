<?php namespace WebEd\Plugins\Share\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;

class ShareRepository extends EloquentBaseRepository implements ShareRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createShare(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateShare($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateShare($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteShare($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
