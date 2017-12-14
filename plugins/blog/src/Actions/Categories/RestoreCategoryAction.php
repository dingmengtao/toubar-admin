<?php namespace WebEd\Plugins\Blog\Actions\Categories;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class RestoreCategoryAction extends AbstractAction
{
    /**
     * @var CategoryRepository
     */
    protected $repository;

    public function __construct(CategoryRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_RESTORE, $id, WEBED_BLOG_CATEGORIES);

        $result = $this->repository->restore($id);

        do_action(BASE_ACTION_AFTER_RESTORE, WEBED_BLOG_CATEGORIES, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
