<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\Item;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\ItemRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\ItemRepository;

class UpdateItemAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run($id, array $data)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_TOUBAR_INVESTOR, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateItem($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_TOUBAR_INVESTOR, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
