<?php namespace WebEd\Base\StaticBlocks\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\StaticBlocks\Repositories\Contracts\StaticBlockRepositoryContract;
use WebEd\Base\StaticBlocks\Repositories\StaticBlockRepository;

class CreateStaticBlockAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_STATIC_BLOCKS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createStaticBlock($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_STATIC_BLOCKS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
