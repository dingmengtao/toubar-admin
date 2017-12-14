<?php namespace WebEd\Plugins\Blog\Actions\Tags;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

class CreateTagAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_TAGS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->create($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_TAGS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
