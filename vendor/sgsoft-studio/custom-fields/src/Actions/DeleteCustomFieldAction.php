<?php namespace WebEd\Base\CustomFields\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;

class DeleteCustomFieldAction extends AbstractAction
{
    /**
     * @var FieldGroupRepository
     */
    protected $fieldGroupRepository;

    public function __construct(FieldGroupRepositoryContract $fieldGroupRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
    }

    /**
     * @param $id
     * @return array
     */
    public function run($id)
    {
        $id = do_filter(BASE_FILTER_BEFORE_DELETE, $id, WEBED_CUSTOM_FIELDS);

        $result = $this->fieldGroupRepository->deleteFieldGroup($id);

        do_action(BASE_ACTION_AFTER_DELETE, WEBED_CUSTOM_FIELDS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
