<?php namespace WebEd\Base\ACL\Repositories\Contracts;

interface PermissionRepositoryContract
{
    /**
     * @param string $name
     * @param string $alias
     * @param string $module
     * @return $this
     */
    public function registerPermission($name, $alias, $module);

    /**
     * @param string|array $alias
     * @param bool $force
     * @return $this
     */
    public function unsetPermission($alias, $force = false);

    /**
     * @param string|array $module
     * @param bool $force
     * @return $this
     */
    public function unsetPermissionByModule($module, $force = false);
}
