<?php namespace WebEd\Plugins\Blog\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Plugins\Blog\Repositories\Contracts\ProductRepositoryContract;

class DeleteProductAction extends AbstractAction
{
    protected $repository;
    public function __construct(ProductRepositoryContract $repository)
    {
        $this->repository=$repository;
    }

    public function run($id)
    {
        $item=$this->repository->find($id);
        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }
        $data['updated_by'] = get_current_logged_user_id();
        $result = $this->repository->deleteProduct($item, $data);
        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
