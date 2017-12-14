<?php namespace WebEd\Base\Menu\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\Menu\Repositories\Contracts\MenuRepositoryContract;
use WebEd\Base\Menu\Repositories\MenuRepository;

class CreateMenuAction extends AbstractAction
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
     * @param array $data
     * @param array|null $menuStructure
     * @return array
     */
    public function run(array $data, array $menuStructure = null)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_MENUS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createMenu($data, $menuStructure);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_MENUS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
