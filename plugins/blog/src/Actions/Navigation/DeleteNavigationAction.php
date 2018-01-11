<?php namespace WebEd\Plugins\Blog\Actions\Navigation;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;
use WebEd\Plugins\Blog\Repositories\NavigationRepository;

class DeleteNavigationAction extends AbstractAction
{
    /**
     * @var NavigationRepositoryContract
     */
    protected $repository;

    public function __construct(NavigationRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_BLOG_NAVIGATION);

        $result = $this->repository->deleteNavigation($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_BLOG_NAVIGATION, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
