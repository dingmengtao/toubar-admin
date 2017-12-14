<?php namespace WebEd\Base\ACL\Repositories;

use WebEd\Base\ACL\Models\Role;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

class RoleRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements RoleRepositoryContract
{
    /**
     * @param $roleId
     * @param array $data
     * @return bool
     */
    public function syncPermissions($roleId, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array|int $id
     * @return bool
     */
    public function deleteRole($id)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @return int
     */
    public function createRole(array $data, array $permissions = [])
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param array $data
     * @param array $permissions
     * @return int|null
     */
    public function updateRole($id, array $data, array $permissions = [])
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param Role|int $id
     * @return array
     */
    public function getRelatedPermissions($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
