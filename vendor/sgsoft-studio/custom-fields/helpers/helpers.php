<?php

use WebEd\Base\CustomFields\Facades\CustomFieldSupportFacade;
use WebEd\Base\CustomFields\Support\CustomFieldSupport;

if (!function_exists('parse_custom_fields_raw_data')) {
    /**
     * @param $jsonString
     * @return array
     */
    function parse_custom_fields_raw_data($jsonString)
    {
        try {
            $fieldGroups = json_decode($jsonString);
        } catch (\Exception $exception) {
            return [];
        }

        $result = [];
        foreach ($fieldGroups as $fieldGroup) {
            foreach ($fieldGroup->items as $item) {
                $result[] = $item;
            }
        }
        return $result;
    }
}

if (!function_exists('add_custom_fields_rules_to_check')) {
    /**
     * @param string|array $ruleName
     * @param $value
     * @return CustomFieldSupport
     */
    function add_custom_fields_rules_to_check($ruleName, $value = null)
    {
        return CustomFieldSupportFacade::addRule($ruleName, $value);
    }
}

if (!function_exists('get_custom_field_boxes')) {
    /**
     * @param string $modelName
     * @param int $modelId
     * @return array
     */
    function get_custom_field_boxes($modelName, $modelId)
    {
        if (is_object($modelName)) {
            $modelName = get_class($modelName);
        }
        return CustomFieldSupportFacade::exportCustomFieldsData($modelName, $modelId);
    }
}
