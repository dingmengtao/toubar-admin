<?php namespace WebEd\Plugins\Blog\Actions\Tags;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\BlogTagRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\BlogTagRepositoryContract;

class UpdateTagAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run($id, array $data)
    {
        $item = $this->repository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_BLOG_TAGS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->repository->update($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_BLOG_TAGS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
