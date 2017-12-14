<?php namespace WebEd\Base\CustomFields\Repositories\Contracts;

use Illuminate\Support\Collection;
use WebEd\Base\Models\Contracts\BaseModelContract;

interface FieldItemRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createFieldItem(array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateFieldItem($id, array $data);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateFieldItem($id, array $data);

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteFieldItem($id);

    /**
     * @param $groupId
     * @param null $parentId
     * @return Collection
     */
    public function getGroupItems($groupId, $parentId = null);

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int|null
     */
    public function updateWithUniqueSlug($id, array $data);
}
