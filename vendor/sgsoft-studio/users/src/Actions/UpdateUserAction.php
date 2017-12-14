<?php namespace WebEd\Base\Users\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class UpdateUserAction extends AbstractAction
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
     * @param array $data
     * @param array|null $roles
     * @return array
     */
    public function run($id, array $data, $roles = null)
    {
        if (
            (get_current_logged_user_id() != $id && !get_current_logged_user()->hasPermission('edit-other-users')) ||
            ($roles && !get_current_logged_user()->hasPermission('assign-roles'))
        ) {
            response_with_messages(trans('webed-core::errors.' . \Constants::FORBIDDEN_CODE . '.message'), true, \Constants::FORBIDDEN_CODE);
        }

        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_USERS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateUser($item, $data, $roles);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_USERS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
