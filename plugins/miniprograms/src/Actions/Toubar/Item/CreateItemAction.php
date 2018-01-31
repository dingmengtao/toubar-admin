<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Item;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\ItemRepository;

class CreateItemAction extends AbstractAction
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
     * @param array $data
     * @param array $trades
     * @return array
     */
    public function run(array $data, array $trades)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_INVESTOR, 'create.post');

        $data['created_by'] = get_current_logged_user_id();
        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->createItem($data, $trades);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_TOUBAR_INVESTOR, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
