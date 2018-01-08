<?php namespace WebEd\Plugins\Banner\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Plugins\Banner\Repositories\Contracts\BannerRepositoryContract;

class BannerRepository extends EloquentBaseRepository implements BannerRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createBanner(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateBanner($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateBanner($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteBanner($id, $force = false)
    {
        return $this->delete($id, $force);
    }

}
