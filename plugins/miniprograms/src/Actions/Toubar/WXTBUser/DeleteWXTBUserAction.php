<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\WXTBUser;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\UserRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\UserRepository;

class DeleteWXTBUserAction extends AbstractAction
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepositoryContract $repository)
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
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_TOUBAR_USER);

        $result = $this->repository->deleteUser($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_TOUBAR_USER, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
