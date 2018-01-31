<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Miniprograms\Models\Contracts\InvestorModelContract;
use WebEd\Plugins\Miniprograms\Models\Investor;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\InvestorRepositoryContract;

class InvestorRepository extends EloquentBaseRepository implements InvestorRepositoryContract
{
    use EloquentUseSoftDeletes;
    /**
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function createInvestor(array $data, array $trades)
    {
        $result = $this->create($data);
        if ($result) {
            if ($trades !== null) {
                $this->syncInvestorTrades($result, $trades);
            }
        }
        return $result;
    }
    /**
     * @param Investor|int $model
     * @param array $trades
     * @return bool|null
     */
    public function syncInvestorTrades($model, array $trades)
    {
        $model = $model instanceof Investor ? $model : $this->find($model);

        try {
            $model->investor_trades()->sync($trades);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
    /**
     * @param InvestorModelContract|int $model
     * @return array
     */
    public function getRelatedTradeIds($model){
        $model = $model instanceof Investor ? $model : $this->find($model);

        try {
            return $model->investor_trades()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateInvestor($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function updateInvestor($id, array $data, $trades)
    {
        $result = $this->update($id, $data);
        if ($result) {
            if ($trades !== null) {
                $this->syncInvestorTrades($result, $trades);
            }
        }
        return $result;
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteInvestor($id, $force = false)
    {
        return $this->delete($id, $force);
    }


}
