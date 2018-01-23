<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;

class InvestorRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements InvestorRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createInvestor(array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateInvestor($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateInvestor($id, array $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteInvestor($id, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
