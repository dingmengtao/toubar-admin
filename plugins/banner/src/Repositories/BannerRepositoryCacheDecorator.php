<?php namespace WebEd\Plugins\Banner\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Banner\Repositories\Contracts\BannerRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class BannerRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements BannerRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createBanner(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateBanner($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateBanner($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteBanner($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
