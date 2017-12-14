<?php namespace WebEd\Base\ACL\Actions;

use WebEd\Base\Actions\AbstractAction;

class DeleteRoleAction extends AbstractAction
{
    /**
     * @var YourRepository
     */
    protected $repository;

    public function __construct(YourRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, your_screen_name);

        $result = $this->repository->delete($id);

        do_action(BASE_ACTION_AFTER_DELETE, your_screen_name, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
