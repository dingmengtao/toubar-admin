<?php namespace WebEd\Plugins\Blog\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\ProductRepositoryContract;
use WebEd\Plugins\Blog\Repositories\ProductRepository;


class CreateProductAction extends AbstractAction
{
    protected $repository;
    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository=$repository;
    }

    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_BLOG_PRODUCTS, 'create.post');
        $data['created_by'] = get_current_logged_user_id();
        $result=$this->repository->createProduct($data);
        do_action(BASE_ACTION_AFTER_CREATE, WEBED_BLOG_PRODUCTS, $result);
        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
