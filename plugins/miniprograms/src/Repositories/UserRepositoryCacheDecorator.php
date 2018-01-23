<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class UserRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements UserRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createUser(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateUser($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateUser($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteUser($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
