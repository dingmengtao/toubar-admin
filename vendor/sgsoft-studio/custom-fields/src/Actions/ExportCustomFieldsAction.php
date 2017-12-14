<?php namespace WebEd\Base\CustomFields\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;
use WebEd\Base\CustomFields\Repositories\FieldItemRepository;

class ExportCustomFieldsAction extends AbstractAction
{
    /**
     * @var FieldGroupRepository
     */
    protected $fieldGroupRepository;

    /**
     * @var FieldItemRepository
     */
    protected $fieldItemRepository;

    public function __construct(
        FieldGroupRepositoryContract $fieldGroupRepository,
        FieldItemRepositoryContract $fieldItemRepository
    )
    {
        $this->fieldGroupRepository = $fieldGroupRepository;

        $this->fieldItemRepository = $fieldItemRepository;
    }

    /**
     * @param array $fieldGroupIds
     * @return array
     */
    public function run(array $fieldGroupIds)
    {
        if (!$fieldGroupIds) {
            $fieldGroups = $this->fieldGroupRepository
                ->get(['id', 'title', 'status', 'order', 'rules'])
                ->toArray();
        } else {
            $fieldGroups = $this->fieldGroupRepository
                ->getWhere([
                    ['id', 'IN', $fieldGroupIds]
                ], ['id', 'title', 'status', 'order', 'rules'])
                ->toArray();
        }

        foreach ($fieldGroups as &$fieldGroup) {
            $fieldGroup['items'] = $this->getFieldItems($fieldGroup['id']);
        }

        return $this->success(null, $fieldGroups);
    }

    /**
     * @param $fieldGroupId
     * @param null $parentId
     * @return array
     */
    protected function getFieldItems($fieldGroupId, $parentId = null)
    {
        $fieldItems = $this->fieldItemRepository
            ->getWhere([
                'field_group_id' => $fieldGroupId,
                'parent_id' => $parentId
            ])
            ->toArray();

        foreach ($fieldItems as &$fieldItem) {
            $fieldItem['children'] = $this->getFieldItems($fieldGroupId, $fieldItem['id']);
        }

        return $fieldItems;
    }
}
