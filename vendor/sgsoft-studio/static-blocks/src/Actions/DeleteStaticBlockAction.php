<?php namespace WebEd\Base\StaticBlocks\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;

class DeleteStaticBlockAction extends AbstractAction
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
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_STATIC_BLOCKS);

        $result = $this->repository->deleteStaticBlock($id);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_STATIC_BLOCKS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
