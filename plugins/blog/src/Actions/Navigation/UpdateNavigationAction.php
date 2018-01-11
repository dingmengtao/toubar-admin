<?php namespace WebEd\Plugins\Blog\Actions\Navigation;

use WebEd\Base\Actions\AbstractAction;
use  WebEd\Plugins\Blog\Repositories\NavigationRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\NavigationRepositoryContract;


class UpdateNavigationAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run($id, array $data)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_NAVIGATION, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateNavigation($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_BLOG_NAVIGATION, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
