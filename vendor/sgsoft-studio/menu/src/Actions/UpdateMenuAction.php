<?php namespace WebEd\Base\Menu\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class UpdateMenuAction extends AbstractAction
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
     * @param array $data
     * @param array|null $menuStructure
     * @param array|null $deletedNodes
     * @return array
     */
    public function run($id, array $data, array $menuStructure = null, array $deletedNodes = null)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_MENUS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateMenu($item, $data, $menuStructure, $deletedNodes);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_MENUS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
