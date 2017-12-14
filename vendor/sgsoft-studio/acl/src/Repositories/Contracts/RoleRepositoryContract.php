<?php namespace WebEd\Base\ACL\Repositories\Contracts;

use WebEd\Base\ACL\Models\Role;

interface RoleRepositoryContract
{
    /**
     * @param $roleId
     * @param array $data
     * @return bool
     */
    public function syncPermissions($roleId, array $data);

    /**
     * @param array|int $id
     * @return bool
     */
    public function deleteRole($id);

    /**
     * @param array $data
     * @return int
     */
    public function createRole(array $data, array $permissions = []);

    /**
     * @param $id
     * @param array $data
     * @param array $permissions
     * @return int|null
     */
    public function updateRole($id, array $data, array $permissions = []);

    /**
     * @param Role|int $id
     * @return array
     */
    public function getRelatedPermissions($id);
}
