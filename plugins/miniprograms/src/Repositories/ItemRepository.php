<?php namespace WebEd\Plugins\Miniprograms\Repositories;

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use WebEd\Plugins\Miniprograms\Models\Contracts\ItemModelContract;
use WebEd\Plugins\Miniprograms\Models\Item;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;

class ItemRepository extends EloquentBaseRepository implements ItemRepositoryContract
{
    use EloquentUseSoftDeletes;
    /**
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function createItem(array $data, array $trades)
    {
        $result = $this->create($data);
        if ($result) {
            if ($trades !== null) {
                $this->syncItemTrades($result, $trades);
            }
        }
        return $result;
    }
    /**
     * @param Item|int $model
     * @param array $trades
     * @return bool|null
     */
    public function syncItemTrades($model, array $trades)
    {
        $model = $model instanceof Item ? $model : $this->find($model);

        try {
            $model->item_trades()->sync($trades);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
    /**
     * @param ItemModelContract|int $model
     * @return array
     */
    public function getRelatedTradeIds($model){
        $model = $model instanceof Item ? $model : $this->find($model);

        try {
            return $model->item_trades()->allRelatedIds()->toArray();
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateItem($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @param array $trades
     * @return int
     */
    public function updateItem($id, array $data, array $trades)
    {
        $result = $this->update($id, $data);
        if ($result) {
            if ($trades !== null) {
                $this->syncItemTrades($result, $trades);
            }
        }
        return $result;
    }

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteItem($id, $force = false)
    {
        return $this->delete($id, $force);
    }
}
