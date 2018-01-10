<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface NavigationRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createNavigation(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateNavigation($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateNavigation($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteNavigation($id, $force = false);
}
