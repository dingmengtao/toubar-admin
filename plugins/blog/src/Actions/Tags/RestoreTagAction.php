<?php namespace WebEd\Plugins\Blog\Actions\Tags;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

class RestoreTagAction extends AbstractAction
{
    /**
     * @var BlogTagRepository
     */
    protected $repository;

    public function __construct(BlogTagRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_RESTORE, $id, WEBED_BLOG_TAGS);

        $result = $this->repository->restore($id);

        do_action(BASE_ACTION_AFTER_RESTORE, WEBED_BLOG_TAGS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
