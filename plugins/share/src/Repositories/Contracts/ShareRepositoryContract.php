<?php namespace WebEd\Plugins\Share\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface ShareRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createShare(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateShare($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateShare($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteShare($id, $force = false);
    
    /**
     * @param array $params
     * @return mixed
     */
    public function getShare(array $params);
}
