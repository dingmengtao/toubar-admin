<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class AuthFrontRequest extends Request
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
