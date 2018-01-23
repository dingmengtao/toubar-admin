<?php namespace WebEd\Plugins\Miniprograms\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface InvestorRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createInvestor(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateInvestor($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateInvestor($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteInvestor($id, $force = false);
}
