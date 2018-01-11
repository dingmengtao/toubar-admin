<?php namespace WebEd\Plugins\Share\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Share\Repositories\Contracts\ShareRepositoryContract;
use WebEd\Plugins\Share\Repositories\ShareRepository;

class RestoreShareAction extends AbstractAction
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
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_RESTORE, $id, WEBED_SHARE);

        $result = $this->repository->restore($id);

        do_action(BASE_ACTION_AFTER_RESTORE, WEBED_SHARE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
