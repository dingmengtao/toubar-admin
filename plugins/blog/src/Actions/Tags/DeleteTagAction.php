<?php namespace WebEd\Plugins\Blog\Actions\Tags;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

class DeleteTagAction extends AbstractAction
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
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_BLOG_TAGS);

        $result = $this->repository->delete($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_BLOG_TAGS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
