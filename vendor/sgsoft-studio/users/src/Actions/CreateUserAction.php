<?php namespace WebEd\Base\Users\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Users\Repositories\Contracts\UserRepositoryContract;
use WebEd\Base\Users\Repositories\UserRepository;

class CreateUserAction extends AbstractAction
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
     * @param array $data
     * @param array $roles
     * @return array
     */
    public function run(array $data, $roles = null)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_USERS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createUser($data, $roles);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_USERS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
