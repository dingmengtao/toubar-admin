<?php namespace WebEd\Base\CustomFields\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldItemRepositoryContract;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;
use WebEd\Base\CustomFields\Repositories\FieldItemRepository;
use Illuminate\Support\Facades\DB;

class ImportCustomFieldsAction extends AbstractAction
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
     * @param array $fieldGroupsData
     * @return array
     */
    public function run(array $fieldGroupsData)
    {
        DB::beginTransaction();
        foreach ($fieldGroupsData as $fieldGroup) {
            $fieldGroup['created_by'] = get_current_logged_user_id();
            $id = $this->fieldGroupRepository
                ->create($fieldGroup);
            if (!$id) {
                DB::rollBack();
                return $this->error();
            }
            $createItems = $this->createFieldItem(array_get($fieldGroup, 'items', []), $id);
            if (!$createItems) {
                DB::rollBack();
                return $this->error();
            }
        }
        DB::commit();
        return $this->success();
    }

    protected function createFieldItem(array $items, $fieldGroupId, $parentId = null)
    {
        foreach ($items as $item) {
            $item['field_group_id'] = $fieldGroupId;
            $item['parent_id'] = $parentId;
            $item['created_by'] = get_current_logged_user_id();
            $id = $this->fieldItemRepository
                ->create($item);
            if (!$id) {
                return false;
            }
            $createChildren = $this->createFieldItem(array_get($item, 'children', []), $fieldGroupId, $id);
            if (!$createChildren) {
                return false;
            }
        }
        return true;
    }
}
