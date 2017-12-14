<?php namespace WebEd\Base\ACL\Support;

class CheckUserACL
{
    protected $permissions = [];

    protected $roles = [];

    /**
     * @param $userId
     * @param array $roles
     * @return $this
     */
    public function pushRoles($userId, array $roles)
    {
        $this->roles[$userId] = array_unique(array_merge(array_get($this->roles, $userId, []), array_values($roles)));
        return $this;
    }

    /**
     * @param $userId
     * @param array $permissions
     * @return $this
     */
    public function pushPermissions($userId, array $permissions)
    {
        $this->permissions[$userId] = array_unique(array_merge(array_get($this->permissions, $userId, []), array_values($permissions)));
        return $this;
    }

    /**
     * @param $userId
     * @param array $permissions
     * @return bool
     */
    public function hasPermissions($userId, array $permissions)
    {
        if (empty(array_diff($permissions, array_get($this->permissions, $userId, [])))) {
            return true;
        }
        return false;
    }

    /**
     * @param $userId
     * @param array $roles
     * @return bool
     */
    public function hasRoles($userId, array $roles)
    {
        if (empty(array_diff($roles, array_get($this->roles, $userId, [])))) {
            return true;
        }
        return false;
    }

    /**
     * @param null $userId
     * @return array
     */
    public function getRoles($userId = null)
    {
        if ($userId) {
            return array_get($this->roles, $userId);
        }
        return $this->roles;
    }

    /**
     * @param null $userId
     * @return array
     */
    public function getPermissions($userId = null)
    {
        if ($userId) {
            return array_get($this->permissions, $userId);
        }
        return $this->permissions;
    }
}
