<?php namespace WebEd\Base\CustomFields\Repositories\Contracts;

use WebEd\Base\Models\Contracts\BaseModelContract;

interface CustomFieldRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createCustomField(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateCustomField($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateCustomField($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteCustomField($id);
}
