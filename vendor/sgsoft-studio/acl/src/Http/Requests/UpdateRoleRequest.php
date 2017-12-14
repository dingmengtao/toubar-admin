<?php namespace WebEd\Base\ACL\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class UpdateRoleRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
        ];
    }
}
