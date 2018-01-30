<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Item;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\ItemRepository;

class DeleteItemAction extends AbstractAction
{
    /**
     * @var ItemRepository
     */
    protected $repository;

    public function __construct(ItemRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_TOUBAR_ITEM);

        $result = $this->repository->deleteItem($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_TOUBAR_ITEM, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
