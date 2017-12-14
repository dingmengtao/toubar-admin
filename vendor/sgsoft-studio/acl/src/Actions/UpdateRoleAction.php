<?php namespace WebEd\Base\ACL\Actions;

use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\RoleRepository;
use WebEd\Base\Actions\AbstractAction;

class UpdateRoleAction extends AbstractAction
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
     * @param $id
     * @param array $data
     * @param array $permissions
     * @return array
     */
    public function run($id, array $data, array $permissions = [])
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_ACL_ROLE, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateRole($item, $data, $permissions);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_ACL_ROLE, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
