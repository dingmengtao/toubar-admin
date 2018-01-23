<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface UserRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createUser(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateUser($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateUser($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteUser($id, $force = false);
}
