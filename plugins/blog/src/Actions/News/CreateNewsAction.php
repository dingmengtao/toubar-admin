<?php namespace WebEd\Plugins\Blog\Actions\News;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\NewsRepositoryContract;

class CreateNewsAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_NEWS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createNews($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_NEWS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
