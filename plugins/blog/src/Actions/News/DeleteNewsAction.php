<?php namespace WebEd\Plugins\Blog\Actions\News;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\NewsRepositoryContract;
use WebEd\Plugins\Blog\Repositories\NewsRepository;

class DeleteNewsAction extends AbstractAction
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
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_BLOG_NEWS);

        $result = $this->repository->deleteNews($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_BLOG_NEWS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
