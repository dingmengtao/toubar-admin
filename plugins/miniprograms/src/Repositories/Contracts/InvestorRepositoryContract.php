<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Plugins\Miniprograms\Models\Contracts\InvestorModelContract;

interface InvestorRepositoryContract
{
    /**
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function createInvestor(array $data, array $trades);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateInvestor($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function updateInvestor($id, array $data, $trades);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteInvestor($id, $force = false);

    /**
     * @param InvestorModelContract|int $model
     * @return array
     */
    public function getRelatedTradeIds($model);

}
