<?php namespace WebEd\Plugins\Blog\Actions\Categories;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\CategoryRepository;
use WebEd\Plugins\Blog\Repositories\Contracts\CategoryRepositoryContract;

class CreateCategoryAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_CATEGORIES, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->repository->createCategory($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_CATEGORIES, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
