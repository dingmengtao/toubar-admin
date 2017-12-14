<?php namespace WebEd\Plugins\Blog\Actions\Posts;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\PostRepositoryContract;
use WebEd\Plugins\Blog\Repositories\PostRepository;

class UpdatePostAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run($id, array $data, array $categories = null, array $tags = null)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_POSTS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->updatePost($item, $data, $categories, $tags);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_BLOG_POSTS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
