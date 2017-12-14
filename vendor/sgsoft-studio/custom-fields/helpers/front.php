<?php

use WebEd\Base\Models\Contracts\BaseModelContract;
use WebEd\Base\Models\EloquentBase;
use WebEd\Base\CustomFields\Repositories\Contracts\CustomFieldRepositoryContract;
use WebEd\Base\CustomFields\Repositories\CustomFieldRepository;

if (!function_exists('get_field')) {
    /**
     * @param int $id
     * @param string $screenName
     * @param null $alias
     * @param null $default
     * @return mixed
     */
    function get_field($id, $screenName, $alias = null, $default = null)
    {
        $customFieldRepository = app(CustomFieldRepositoryContract::class);

        if ($alias === null || !trim($alias)) {
            return $customFieldRepository->findWhere([
                'use_for' => $screenName,
                'use_for_id' => $id,
            ]);
        }

        $field = $customFieldRepository->findWhere([
            'use_for' => $screenName,
            'use_for_id' => $id,
            'slug' => $alias,
        ]);

        if (!$field || !$field->resolved_value) {
            return $default;
        }

        return $field->resolved_value;
    }
}

if (!function_exists('has_field')) {
    /**
     * @param int $id
     * @param string $screenName
     * @param null $alias
     * @return bool
     */
    function has_field($id, $screenName, $alias = null)
    {
        if (!get_field($id, $screenName, $alias)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('get_sub_field')) {
    /**
     * @param array $parentField
     * @param $alias
     * @param null $default
     * @return mixed
     */
    function get_sub_field(array $parentField, $alias, $default = null)
    {
        foreach ($parentField as $field) {
            if (array_get($field, 'slug') === $alias) {
                return array_get($field, 'value', $default);
            }
        }
        return $default;
    }
}

if (!function_exists('has_sub_field')) {
    /**
     * @param array $parentField
     * @param $alias
     * @return bool
     */
    function has_sub_field(array $parentField, $alias)
    {
        if (!get_sub_field($parentField, $alias)) {
            return false;
        }
        return true;
    }
}

