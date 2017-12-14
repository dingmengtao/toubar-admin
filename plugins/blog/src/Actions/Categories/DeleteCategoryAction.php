<?php namespace WebEd\Plugins\Blog\Actions\Categories;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class DeleteCategoryAction extends AbstractAction
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
     * @param bool $force
     * @return array
     */
    public function run($id, $force = false)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_BLOG_CATEGORIES);

        $result = $this->repository->delete($id, $force);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_BLOG_CATEGORIES, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
