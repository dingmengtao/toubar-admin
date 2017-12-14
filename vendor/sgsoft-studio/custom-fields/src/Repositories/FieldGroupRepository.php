<?php namespace WebEd\Base\CustomFields\Repositories;

use Illuminate\Support\Collection;
use WebEd\Base\CustomFields\Models\Contracts\CustomFieldModelContract;
use WebEd\Base\CustomFields\Repositories\Contracts\CustomFieldRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Repositories\Eloquent\EloquentBaseRepository;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;

class FieldGroupRepository extends EloquentBaseRepository implements FieldGroupRepositoryContract
{
    /**
     * @var FieldItemRepository
     */
    protected $fieldItemRepository;

    /**
     * @var CustomFieldRepository
     */
    protected $customFieldRepository;

    public function __construct(BaseModelContract $model)
    {
        parent::__construct($model);

        $this->fieldItemRepository = app(FieldItemRepositoryContract::class);
        $this->customFieldRepository = app(CustomFieldRepositoryContract::class);
    }

    /**
     * @param array $condition
     * @return Collection
     */
    public function getFieldGroups(array $condition = [])
    {
        return $this->model
            ->where($condition)
            ->orderBy('order', 'ASC')
            ->get();
    }

    /**
     * @param int $groupId
     * @param null $parentId
     * @param bool $withValue
     * @param null $morphClass
     * @param null $morphId
     * @return array
     */
    public function getFieldGroupItems($groupId, $parentId = null, $withValue = false, $morphClass = null, $morphId = null)
    {
        $result = [];

        $fieldItems = $this->fieldItemRepository->getGroupItems($groupId, $parentId);

        foreach ($fieldItems as $key => $row) {
            $item = [
                'id' => $row->id,
                'title' => $row->title,
                'slug' => $row->slug,
                'instructions' => $row->instructions,
                'type' => $row->type,
                'options' => json_decode($row->options),
                'items' => $this->getFieldGroupItems($groupId, $row->id, $withValue, $morphClass, $morphId),
            ];
            if ($withValue === true) {
                if ($row->type === 'repeater') {
                    $item['value'] = $this->getRepeaterValue($item['items'], $this->getFieldItemValue($row, $morphClass, $morphId));
                } else {
                    $item['value'] = $this->getFieldItemValue($row, $morphClass, $morphId);
                }
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * @param array $data
     * @return int
     */
    public function createFieldGroup(array $data)
    {
        $result = $this->create($data);

        if ($result) {
            if (array_get($data, 'group_items')) {
                $this->editGroupItems(json_decode($data['group_items'], true), $result);
            }
        }

        return $result;
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function createOrUpdateFieldGroup($id, array $data)
    {
        $result = $this->createOrUpdate($id, $data);
        if ($result) {
            if (array_get($data, 'deleted_items')) {
                $this->fieldItemRepository->deleteFieldItem(json_decode($data['deleted_items'], true));
            }

            if (array_get($data, 'group_items')) {
                $this->editGroupItems(json_decode($data['group_items'], true), $result);
            }
        }
        return $result;
    }

    /**
     * @param int|null|BaseModelContract $id
     * @param array $data
     * @return int
     */
    public function updateFieldGroup($id, array $data)
    {
        $result = $this->update($id, $data);

        if ($result) {
            if (array_get($data, 'deleted_items')) {
                $this->fieldItemRepository->deleteFieldItem(json_decode($data['deleted_items'], true));
            }

            if (array_get($data, 'group_items')) {
                $this->editGroupItems(json_decode($data['group_items'], true), $result);
            }
        }
        return $result;
    }

    /**
     * @param int|BaseModelContract|array $id
     * @return bool
     */
    public function deleteFieldGroup($id)
    {
        return $this->delete($id);
    }

    /**
     * @param $fieldItem
     * @param $morphClass
     * @param $morphId
     * @return CustomFieldModelContract|mixed
     */
    protected function getFieldItemValue($fieldItem, $morphClass, $morphId)
    {
        if (is_object($morphClass)) {
            $morphClass = get_class($morphClass);
        }

        $field = $this->customFieldRepository->findWhere([
            'use_for' => $morphClass,
            'use_for_id' => $morphId,
            'field_item_id' => $fieldItem->id,
        ]);

        return ($field) ? $field->value : null;
    }

    /**
     * @param $items
     * @param $data
     * @return array|null
     */
    protected function getRepeaterValue($items, $data)
    {
        if (!$items) {
            return null;
        }
        $data = ($data) ?: [];
        if (!is_array($data)) {
            $data = json_decode($data, true);
        }
        $result = [];
        foreach ($data as $key => $row) {
            $cloned = $items;
            foreach ($cloned as $keyItem => $item) {
                foreach ($row as $currentData) {
                    if ((int)$item['id'] === (int)$currentData['field_item_id']) {
                        if ($item['type'] === 'repeater') {
                            $item['value'] = $this->getRepeaterValue($item['items'], $currentData['value']);
                        } else {
                            $item['value'] = $currentData['value'];
                        }
                        $cloned[$keyItem] = $item;
                    }
                }
            }
            $result[$key] = $cloned;
        }
        return $result;
    }

    /**
     * @param array $items
     * @param int $groupId
     * @param int|null $parentId
     */
    protected function editGroupItems(array $items, $groupId, $parentId = null)
    {
        $position = 0;
        foreach ($items as $key => $row) {
            $position++;

            $id = $row['id'];

            $data = [
                'field_group_id' => $groupId,
                'parent_id' => $parentId,
                'title' => $row['title'],
                'order' => $position,
                'type' => $row['type'],
                'options' => json_encode($row['options']),
                'instructions' => $row['instructions'],
                'slug' => (str_slug($row['slug'], '_')) ?: str_slug($row['title'], '_'),
                'position' => $position,
            ];

            $result = $this->fieldItemRepository->updateWithUniqueSlug($id, $data);

            if ($result) {
                $this->editGroupItems($row['items'], $groupId, $result);
            }
        }
    }
}
