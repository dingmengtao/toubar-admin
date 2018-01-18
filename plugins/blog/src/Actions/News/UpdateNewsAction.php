<?php namespace WebEd\Plugins\Blog\Actions\News;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\NewsRepositoryContract;
use WebEd\Plugins\Blog\Repositories\NewsRepository;

class UpdateNewsAction extends AbstractAction
{
    /**
     * @var NewsRepository
     */
    protected $repository;

    public function __construct(NewsRepositoryContract $repository)
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

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_NEWS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updateNews($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_BLOG_NEWS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
