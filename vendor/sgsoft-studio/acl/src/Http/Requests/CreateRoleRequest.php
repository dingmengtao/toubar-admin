<?php namespace WebEd\Base\ACL\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class CreateRoleRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|max:255|string',
            'slug' => 'required|max:255|alpha_dash',
        ];
    }
}
