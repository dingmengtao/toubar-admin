<?php namespace WebEd\Plugins\Share\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

class DeleteShareAction extends AbstractAction
{
    /**
     * @var ShareRepository
     */
    protected $repository;

    public function __construct(ShareRepositoryContract $repository)
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
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_SHARE);

        $result = $this->repository->deleteShare($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_SHARE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
