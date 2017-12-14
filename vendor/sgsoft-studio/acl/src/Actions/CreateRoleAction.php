<?php namespace WebEd\Base\ACL\Actions;

use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Actions\AbstractAction;

class CreateRoleAction extends AbstractAction
{
    /**
     * @var RoleRepository
     */
    protected $repository;

    public function __construct(RoleRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @param array $permissions
     * @return array
     */
    public function run(array $data, array $permissions = [])
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_ACL_ROLE, 'create.post');
        
        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createRole($data, $permissions);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_ACL_ROLE, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
