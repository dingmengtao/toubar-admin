<?php namespace WebEd\Base\CustomFields\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;

class CreateCustomFieldAction extends AbstractAction
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
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_CUSTOM_FIELDS, 'create.post');

        $data['created_by'] = get_current_logged_user_id();

        $result = $this->fieldGroupRepository->createFieldGroup($data);

        do_action(BASE_ACTION_AFTER_CREATE, WEBED_CUSTOM_FIELDS, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
