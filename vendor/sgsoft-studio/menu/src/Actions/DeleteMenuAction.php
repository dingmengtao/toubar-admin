<?php namespace WebEd\Base\Menu\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class DeleteMenuAction extends AbstractAction
{
    /**
     * @var MenuRepository
     */
    protected $repository;

    public function __construct(MenuRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_MENUS);

        $result = $this->repository->delete($id);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_MENUS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
