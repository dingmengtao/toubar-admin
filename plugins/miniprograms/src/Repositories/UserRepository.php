<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends EloquentBaseRepository implements UserRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createUser(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateUser($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateUser($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteUser($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
