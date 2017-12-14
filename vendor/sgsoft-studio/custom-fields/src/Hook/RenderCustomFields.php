<?php namespace WebEd\Base\CustomFields\Hook;

use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Models\EloquentBase;

class RenderCustomFields
{
    public function __construct()
    {
        $roles = check_user_acl()->getRoles(get_current_logged_user_id());

        add_custom_fields_rules_to_check([
            'logged_in_user' => get_current_logged_user_id(),
            'logged_in_user_has_role' => $roles
        ]);
    }

    /**
     * @param string $location
     * @param string $screenName
     * @param BaseModelContract|EloquentBase $object
     */
    public function handle($location, $screenName, $object = null)
    {
        /**
         * If the location is not in main or the current page is not editing page
         */
        if ($location != 'main' || substr($screenName, -6) == '.index') {
            return;
        }

        switch ($screenName) {
            case 'webed-pages':
                add_custom_fields_rules_to_check([
                    'page_template' => isset($object->page_template) ? $object->page_template : '',
                    'page' => isset($object->id) ? $object->id : '',
                    'model_name' => 'webed-pages',
                ]);
                break;
        }

        $this->render($screenName, isset($object->id) ? $object->id : null);
    }

    /**
     * @param $screenName
     * @param $id
     */
    protected function render($screenName, $id)
    {
        $customFieldBoxes = get_custom_field_boxes($screenName, $id);

        if (!$customFieldBoxes) {
            return;
        }

        CustomFieldSupportFacade::renderAssets();

        echo CustomFieldSupportFacade::renderCustomFieldBoxes($customFieldBoxes);
    }
}
