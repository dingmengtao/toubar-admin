<?php namespace WebEd\Base\Users\Repositories\Contracts;

use Illuminate\Support\Collection;
use WebEd\Base\Users\Models\User;

interface UserRepositoryContract
{
    /**
     * @param User|int $user
     * @param array $data
     */
    public function syncRoles($user, array $data);

    /**
     * @param User|int $user
     * @return Collection
     */
    public function getRoles($user);

    /**
     * @param User $user
     * @return array
     */
    public function getRelatedRoleIds($user);

    /**
     * @param array $data
     * @return int
     */
    public function createUser(array $data, $roles = null);

    /**
     * @param User|int $id
     * @param array $data
     * @return int
     */
    public function updateUser($id, array $data, $roles = null);

    /**
     * @param User|int $user
     * @return bool
     */
    public function isSuperAdmin($user);

    /**
     * @param User|int $user
     * @param array $permissions
     * @return bool
     */
    public function hasPermission($user, array $permissions);

    /**
     * @param User|int $user
     * @param array $roles
     * @return bool
     */
    public function hasRole($user, array $roles);
}
