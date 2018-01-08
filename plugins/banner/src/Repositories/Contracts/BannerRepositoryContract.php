<?php namespace WebEd\Plugins\Banner\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface BannerRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createBanner(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateBanner($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateBanner($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteBanner($id, $force = false);

}
