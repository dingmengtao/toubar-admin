<?php namespace WebEd\Plugins\Blog\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Blog\Models\Navigation;
use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;

class NavigationRepository extends EloquentBaseRepository implements NavigationRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createNavigation(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateNavigation($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateNavigation($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteNavigation($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
