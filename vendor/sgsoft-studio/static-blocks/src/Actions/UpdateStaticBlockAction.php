<?php namespace WebEd\Base\StaticBlocks\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;

class UpdateStaticBlockAction extends AbstractAction
{
    /**
     * @var StaticBlockRepository
     */
    protected $repository;

    public function __construct(StaticBlockRepositoryContract $repository)
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

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_STATIC_BLOCKS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateStaticBlock($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_STATIC_BLOCKS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
