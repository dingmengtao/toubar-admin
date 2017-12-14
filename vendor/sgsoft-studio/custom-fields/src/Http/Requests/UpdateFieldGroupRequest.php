<?php namespace WebEd\Base\CustomFields\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateFieldGroupRequest extends Request
{
    public function rules()
    {
        return [
            'field_group.order' => 'integer|min:0|required',
            'field_group.rules' => 'json|required',
            'field_group.group_items' => 'json|required',
            'field_group.deleted_items' => 'json|nullable',
            'field_group.title' => 'string|required|max:255',
            'field_group.status' => 'required',
        ];
    }
}
