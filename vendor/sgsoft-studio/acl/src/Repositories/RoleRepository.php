<?php namespace WebEd\Base\ACL\Repositories;

use WebEd\Base\ACL\Models\Role;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;

class RoleRepository extends EloquentBaseRepository implements RoleRepositoryContract
{
    /**
     * The roles with these alias cannot be deleted
     * @var array
     */
    protected $cannotDelete = [];

    public function __construct(BaseModelContract $model)
    {
        parent::__construct($model);

        $this->cannotDelete = array_merge(config('webed-acl.cannot_delete_roles', []), ['super-admin']);
    }

    /**
     * @param $roleId
     * @param array $data
     * @return bool
     */
    public function syncPermissions($roleId, array $data)
    {
        try {
            $this->model
                ->find($roleId)
                ->permissions()
                ->sync($data);
            $this->resetModel();
        } catch (\Exception $exception) {
            $this->resetModel();
            return false;
        }

        return true;
    }

    /**
     * @param array|int $id
     * @return bool
     */
    public function deleteRole($id)
    {
        try {
            $this->model
                ->whereNotIn('slug', $this->cannotDelete)
                ->whereIn('id', (array)$id)
                ->delete();
            $this->resetModel();
        } catch (\Exception $exception) {
            $this->resetModel();
            return false;
        }
        return true;
    }

    /**
     * @param array $data
     * @return int
     */
    public function createRole(array $data, array $permissions = [])
    {
        $roleId = $this->create($data);

        /**
         * Sync permissions
         */
        if ($permissions) {
            $this->syncPermissions($roleId, $permissions);
        }

        return $roleId;
    }

    /**
     * @param $id
     * @param array $data
     * @param array $permissions
     * @return int|null
     */
    public function updateRole($id, array $data, array $permissions = [])
    {
        $roleId = $this->update($id, $data);

        /**
         * Sync permissions
         */
        if ($roleId) {
            $this->syncPermissions($roleId, $permissions);
        }

        return $roleId;
    }

    /**
     * @param Role|int $id
     * @return array
     */
    public function getRelatedPermissions($id)
    {
        if ($id instanceof Role) {
            $item = $id;
        } else {
            $item = $this->find($id);
        }

        if (!$item) {
            return [];
        }

        return $item->permissions()->allRelatedIds()->toArray();
    }
}
