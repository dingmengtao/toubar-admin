<?php namespace WebEd\Plugins\Blog\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface ProductRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createProduct(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateProduct($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateProduct($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @param bool $force
     * @return bool
     */
    public function deleteProduct($id, $force = false);
}
