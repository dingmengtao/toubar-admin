<?php namespace WebEd\Base\CustomFields\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;

class FieldItemRepository extends EloquentBaseRepository implements FieldItemRepositoryContract
{
    /**
     * @param array $data
     * @return int
     */
    public function createFieldItem(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateFieldItem($id, array $data)
    {
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateFieldItem($id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteFieldItem($id)
    {
        return $this->delete($id);
    }

    /**
     * @param $groupId
     * @param null $parentId
     * @return Collection
     */
    public function getGroupItems($groupId, $parentId = null)
    {
        return $this->model
            ->where([
                'field_group_id' => $groupId,
                'parent_id' => $parentId
            ])
            ->orderBy('order', 'ASC')
            ->get();
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int|null
     */
    public function updateWithUniqueSlug($id, array $data)
    {
        $data['slug'] = $this->makeUniqueSlug($id, $data['field_group_id'], $data['parent_id'], $data['slug'], $data['position']);
        return $this->createOrUpdate($id, $data);
    }

    /**
     * @param int $id
     * @param int $fieldGroupId
     * @param int $parentId
     * @param string $slug
     * @return string
     */
    protected function makeUniqueSlug($id, $fieldGroupId, $parentId, $slug, $position)
    {
        $isExist = $this->findWhere([
            'slug' => $slug,
            //'field_group_id' => $fieldGroupId,
            'parent_id' => $parentId
        ]);
        if ($isExist && (int)$id != (int)$isExist->id) {
            return $slug . '_' . time() . $position;
        }
        return $slug;
    }
}
