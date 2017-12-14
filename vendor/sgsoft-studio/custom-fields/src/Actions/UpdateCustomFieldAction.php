<?php namespace WebEd\Base\CustomFields\Actions;

use WebEd\Base\Actions\AbstractAction;
use WebEd\Base\CustomFields\Repositories\Contracts\FieldGroupRepositoryContract;
use WebEd\Base\CustomFields\Repositories\FieldGroupRepository;

class UpdateCustomFieldAction extends AbstractAction
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
     * @param array $data
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function run($id, array $data)
    {
        $item = $this->fieldGroupRepository->find($id);

        $item = do_filter(BASE_FILTER_BEFORE_UPDATE, $item, WEBED_CUSTOM_FIELDS, 'edit.post');

        if (!$item) {
            return $this->error(trans('webed-core::base.form.item_not_exists'));
        }

        $data['updated_by'] = get_current_logged_user_id();

        $result = $this->fieldGroupRepository->updateFieldGroup($item, $data);

        do_action(BASE_ACTION_AFTER_UPDATE, WEBED_CUSTOM_FIELDS, $id, $result);

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
