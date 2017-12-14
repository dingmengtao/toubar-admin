<?php namespace WebEd\Base\Users\Http\Requests;

use WebEd\Base\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function rules()
    {
        return [
            'password' => 'required|string|min:5|max:64',
        ];
    }
}
