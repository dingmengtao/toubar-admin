<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class NavigationRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements NavigationRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createNavigation(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateNavigation($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateNavigation($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteNavigation($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
