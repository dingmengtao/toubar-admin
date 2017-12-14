<?php namespace WebEd\Plugins\Blog\Actions\Posts;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class DeletePostAction extends AbstractAction
{
    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepositoryContract $repository)
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
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_BLOG_POSTS);

        $result = $this->repository->deletePost($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_BLOG_POSTS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
