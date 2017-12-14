<?php namespace WebEd\Plugins\Blog\Actions\Posts;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class CreatePostAction extends AbstractAction
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
     * @param array $data
     * @param array $categories
     * @param array $tags
     * @return array
     */
    public function run(array $data, array $categories = null, array $tags = null)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_POSTS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createPost($data, $categories, $tags);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_POSTS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
