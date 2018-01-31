<?php namespace WebEd\Plugins\Miniprograms\Actions\Toubar\WXTBUser;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Miniprograms\Repositories\Contracts\UserRepositoryContract;
use WebEd\Plugins\Miniprograms\Repositories\UserRepository;

class CreateWXTBUserAction extends AbstractAction
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
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_TOUBAR_USER, 'create.post');

        $data['created_by'] = get_current_logged_user_id();
        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->createUser($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_TOUBAR_USER, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
