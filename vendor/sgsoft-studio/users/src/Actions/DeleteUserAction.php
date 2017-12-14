<?php namespace WebEd\Base\Users\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class DeleteUserAction extends AbstractAction
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
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_USERS);

        if ($id == get_current_logged_user_id()) {
            return response_with_messages(
                trans('webed-users::base.cannot_update_status_yourself'),
                true,
                \Constants::FORBIDDEN_CODE
            );
        }

        $result = $this->repository->delete($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_USERS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
